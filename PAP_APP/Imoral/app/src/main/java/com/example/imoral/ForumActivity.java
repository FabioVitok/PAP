package com.example.imoral;

import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.view.View;
import android.widget.ImageButton;
import android.widget.ImageView;
import android.widget.Toast;

import androidx.appcompat.app.AppCompatActivity;
import androidx.recyclerview.widget.GridLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import com.example.imoral.adapters.PostAdapter;
import com.example.imoral.models.Carrinhos.AdicionarCarrinhoResponse;
import com.example.imoral.models.Forum.ForumResponse;
import com.example.imoral.models.Forum.PostarResponse;
import com.example.imoral.models.Post;
import com.example.imoral.models.Utilizador;
import com.google.gson.Gson;

import org.json.JSONException;
import org.json.JSONObject;

import java.io.IOException;
import java.util.ArrayList;
import java.util.List;

import okhttp3.Call;
import okhttp3.Callback;
import okhttp3.MediaType;
import okhttp3.OkHttpClient;
import okhttp3.Request;
import okhttp3.RequestBody;
import okhttp3.Response;
import utils.ApiConfig;

public class ForumActivity extends AppCompatActivity {

    private final OkHttpClient client = new OkHttpClient();
    private final Gson gson = new Gson();
    private PostAdapter postAdapter;
    private RecyclerView rvPosts;
    private ImageButton btnCreatePost;
    private ImageView btnForum, btnCarrinho, btnUser, btnHome;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_forum);
        initializeView();
        setupPostsList();
        CarregarPosts();
        listeners();
        }

        private void initializeView(){
            btnCreatePost = findViewById(R.id.btnCreatePost);
            rvPosts = findViewById(R.id.rvPosts);
            btnForum = findViewById(R.id.btnForum);
            btnCarrinho = findViewById(R.id.btnCarrinho);
            btnUser = findViewById(R.id.btnUser);
            btnHome = findViewById(R.id.btnHome);
        }

        private void listeners(){
            btnHome.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {
                    Intent intent = new Intent(ForumActivity.this, MainActivity.class);
                    startActivity(intent);
                    finish();
                }
            });
            btnForum.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {
                    CarregarPosts();
                }
            });

            btnCarrinho.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {
                    Intent intent = new Intent(ForumActivity.this, CarrinhoActivity.class);
                    startActivity(intent);
                    finish();
                }
            });

            btnUser.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {
                    Intent intent = new Intent(ForumActivity.this, UserActivity.class);
                    startActivity(intent);
                    finish();
                }
            });

            btnCreatePost.setOnClickListener(v -> {
                openPostarFragment();
            });
        }

        private void openPostarFragment(){
            SharedPreferences prefs = getSharedPreferences("app_session", MODE_PRIVATE);
            String username = prefs.getString("username", null);
            String image = prefs.getString("image", null);
            PostFragment postFragment = PostFragment.newInstance(username,image);

            postFragment.setOnPostListener(texto -> {
                CriarPost(texto);
            });

            postFragment.show(getSupportFragmentManager(), "post_fragment");
        }
        private void setupPostsList() {
            postAdapter = new PostAdapter();
            rvPosts.setLayoutManager(new GridLayoutManager(this, 1));
            rvPosts.setAdapter(postAdapter);
        }

    private void CarregarPosts() {
        SharedPreferences prefs = getSharedPreferences("app_session", MODE_PRIVATE);
        String jwt = prefs.getString("jwt", null);

        Request request = new Request.Builder()
                .url(ApiConfig.POSTS_URL)
                .get()
                .addHeader("Authorization", "Bearer " + jwt)
                .build();

        client.newCall(request).enqueue(new Callback() {
            @Override
            public void onFailure(Call call, IOException e) {
                runOnUiThread(() -> Toast.makeText(ForumActivity.this, "Erro: "+ e.getMessage(), Toast.LENGTH_SHORT).show());
            }

            @Override
            public void onResponse(Call call, Response response) throws IOException {
                String responseBody = response.body() != null ? response.body().string() : "";

                try{
                    ForumResponse forumResponse = gson.fromJson(responseBody, ForumResponse.class);

                    if (forumResponse != null && forumResponse.isSuccess()) {
                        List<Post> posts = forumResponse.getData().getPosts();
                        runOnUiThread(() -> {
                            postAdapter.submitList(posts);
                        });
                    } else {
                        runOnUiThread(() -> Toast.makeText(ForumActivity.this, "Resposta inválida", Toast.LENGTH_SHORT).show());
                    }

                } catch (Exception e) {
                    runOnUiThread(() -> Toast.makeText(ForumActivity.this, "Erro ao converter JSON:\n" + e.getMessage(), Toast.LENGTH_SHORT).show());
                }
            }
        });
    }

    private void CriarPost(String texto){
        SharedPreferences prefs = getSharedPreferences("app_session", MODE_PRIVATE);
        String jwt = prefs.getString("jwt", null);
        int UserId = prefs.getInt("user_id", 0);


        JSONObject jsonBody = new JSONObject();
        try {
            jsonBody.put("id_utilizador", UserId);
            jsonBody.put("texto_post", texto);
        } catch (JSONException e) {
            e.printStackTrace();
            return;
        }

        RequestBody body = RequestBody.create(
                jsonBody.toString(),
                MediaType.parse("application/json")
        );

        Request request = new Request.Builder()
                .url(ApiConfig.POSTS_URL)
                .post(body)
                .addHeader("Authorization", "Bearer " + jwt)
                .build();

        client.newCall(request).enqueue(new Callback() {
            @Override
            public void onFailure(Call call, IOException e) {
                runOnUiThread(() -> Toast.makeText(ForumActivity.this, "Erro: " + e.getMessage(), Toast.LENGTH_SHORT).show());
            }

            @Override
            public void onResponse(Call call, Response response) throws IOException {
                String responseBody = response.body() != null ? response.body().string() : "";
                android.util.Log.d("ADD_CARRINHO", "Status: " + response.code() + " | Body: " + responseBody);
                try {
                    PostarResponse resp = gson.fromJson(responseBody, PostarResponse.class);

                    if (resp != null && resp.isSuccess()) {
                        runOnUiThread(() -> Toast.makeText(ForumActivity.this, "Post Postado!", Toast.LENGTH_SHORT).show());
                        CarregarPosts();
                    } else {
                        runOnUiThread(() -> Toast.makeText(ForumActivity.this, "Erro ao postar", Toast.LENGTH_SHORT).show());
                    }
                } catch (Exception e) {
                    runOnUiThread(() -> Toast.makeText(ForumActivity.this, "Erro ao converter JSON:\n" + e.getMessage(), Toast.LENGTH_SHORT).show());
                }
            }
        });
    }
}

