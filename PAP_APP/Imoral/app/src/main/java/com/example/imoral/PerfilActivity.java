package com.example.imoral;

import android.content.SharedPreferences;
import android.os.Bundle;
import android.widget.ImageButton;
import android.widget.ImageView;
import android.widget.TextView;
import android.widget.Toast;

import androidx.activity.EdgeToEdge;
import androidx.appcompat.app.AppCompatActivity;
import androidx.constraintlayout.widget.ConstraintLayout;
import androidx.core.graphics.Insets;
import androidx.core.view.ViewCompat;
import androidx.core.view.WindowInsetsCompat;
import androidx.recyclerview.widget.GridLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import com.bumptech.glide.Glide;
import com.bumptech.glide.load.engine.DiskCacheStrategy;
import com.example.imoral.adapters.PostAdapter;
import com.example.imoral.models.Forum.ForumResponse;
import com.example.imoral.models.Perfil.PerfilResponse;
import com.example.imoral.models.Post;
import com.example.imoral.models.Utilizador;
import com.google.gson.Gson;

import java.io.IOException;
import java.util.List;

import okhttp3.Call;
import okhttp3.Callback;
import okhttp3.OkHttpClient;
import okhttp3.Request;
import okhttp3.Response;
import utils.ApiConfig;

public class PerfilActivity extends AppCompatActivity {

    private final OkHttpClient client = new OkHttpClient();
    private final Gson gson = new Gson();
    private int  userId;
    private PostAdapter postAdapter;
    private RecyclerView rvPosts;
    private ConstraintLayout btnFollow, btnBack;
    private ImageView ivProfilePicture, ivBanner;
    private TextView tvUsername, tvUsernameTitle, tvSeguidores, tvAseguir;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        EdgeToEdge.enable(this);
        setContentView(R.layout.activity_perfil);
        ViewCompat.setOnApplyWindowInsetsListener(findViewById(R.id.main), (v, insets) -> {
            Insets systemBars = insets.getInsets(WindowInsetsCompat.Type.systemBars());
            v.setPadding(systemBars.left, systemBars.top, systemBars.right, systemBars.bottom);
            return insets;
        });
        userId = getIntent().getIntExtra("userId", -1);
        initializeViews();
        setupPostsList();
        carregarPerfil();
        listeners();
    }

    private void initializeViews() {
        rvPosts = findViewById(R.id.rvPosts);
        ivProfilePicture = findViewById(R.id.ivProfilePicture);
        ivBanner = findViewById(R.id.ivBanner);
        tvUsername = findViewById(R.id.tvUsername);
        tvSeguidores = findViewById(R.id.tvSeguidores);
        tvAseguir = findViewById(R.id.tvAseguir);
        btnFollow = findViewById(R.id.btnFollow);
        tvUsernameTitle = findViewById(R.id.tvUsernameTitle);
        btnBack = findViewById(R.id.header);
    }

    private void listeners() {
        btnBack.setOnClickListener(v -> finish());
    }

    private void setupPostsList() {
        postAdapter = new PostAdapter();
        rvPosts.setLayoutManager(new GridLayoutManager(this, 1));
        rvPosts.setAdapter(postAdapter);
    }
    private void setUserinfo(Utilizador user){
        String userPfp = ApiConfig.BASE_URL + "/" + user.getImage();
        String userBanner = ApiConfig.BASE_URL + "/" + user.getBanner();
        Glide.with(this)
                .load(userPfp)
                .diskCacheStrategy(DiskCacheStrategy.NONE)
                .skipMemoryCache(true)
                .into(ivProfilePicture);
        Glide.with(this)
                .load(userBanner)
                .diskCacheStrategy(DiskCacheStrategy.NONE)
                .skipMemoryCache(true)
                .into(ivBanner);
        tvUsername.setText(user.getUsername());
        tvUsernameTitle.setText(user.getUsername());
        tvSeguidores.setText(String.valueOf(user.getSeguidores()));
        tvAseguir.setText(String.valueOf(user.getSeguindo()));
    }

    private void carregarPerfil() {
        SharedPreferences prefs = getSharedPreferences("app_session", MODE_PRIVATE);
        String jwt = prefs.getString("jwt", null);

        Request request = new Request.Builder()
                .url(ApiConfig.PROFILE_URL + userId)
                .get()
                .addHeader("Authorization", "Bearer " + jwt)
                .build();

        client.newCall(request).enqueue(new Callback() {
            @Override
            public void onFailure(Call call, IOException e) {
                runOnUiThread(() -> Toast.makeText(PerfilActivity.this, "Erro: "+ e.getMessage(), Toast.LENGTH_SHORT).show());
            }

            @Override
            public void onResponse(Call call, Response response) throws IOException {
                String responseBody = response.body() != null ? response.body().string() : "";

                try{
                    PerfilResponse perfilResponse = gson.fromJson(responseBody, PerfilResponse.class);

                    if (perfilResponse != null && perfilResponse.isSuccess()) {
                        List<Post> posts = perfilResponse.getData().getPosts();
                        Utilizador user = perfilResponse.getData().getUser();
                        runOnUiThread(() -> {
                            postAdapter.submitList(posts);
                            setUserinfo(user);
                        });
                    } else {
                        runOnUiThread(() -> Toast.makeText(PerfilActivity.this, "Resposta inválida", Toast.LENGTH_SHORT).show());
                    }

                } catch (Exception e) {
                    runOnUiThread(() -> Toast.makeText(PerfilActivity.this, "Erro ao converter JSON:\n" + e.getMessage(), Toast.LENGTH_SHORT).show());
                }
            }
        });
    }
}