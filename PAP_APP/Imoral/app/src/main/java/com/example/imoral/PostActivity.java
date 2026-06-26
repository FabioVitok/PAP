package com.example.imoral;

import android.content.SharedPreferences;
import android.os.Bundle;
import android.widget.ImageView;
import android.widget.TextView;
import android.widget.Toast;

import androidx.activity.EdgeToEdge;
import androidx.annotation.NonNull;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.graphics.Insets;
import androidx.core.view.ViewCompat;
import androidx.core.view.WindowInsetsCompat;
import androidx.recyclerview.widget.GridLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import com.bumptech.glide.Glide;
import com.example.imoral.adapters.ComentarioAdapter;
import com.example.imoral.models.Comentario;
import com.example.imoral.models.Comments.CommentResponse;
import com.example.imoral.models.Forum.ForumResponse;
import com.example.imoral.models.Post;
import com.google.gson.Gson;

import java.io.IOException;
import java.util.ArrayList;
import java.util.List;

import okhttp3.Call;
import okhttp3.Callback;
import okhttp3.OkHttpClient;
import okhttp3.Request;
import okhttp3.Response;
import utils.ApiConfig;

public class PostActivity extends AppCompatActivity {

    private final OkHttpClient client = new OkHttpClient();
    private final Gson gson = new Gson();
    private ComentarioAdapter comentarioAdapter;
    private RecyclerView rvComments;
    ImageView ivProfilePicture;
    TextView tvUsername;
    TextView tvData;
    TextView tvTexto;
    TextView tvLikeCount;
    TextView tvCommentCount;
    TextView tvBigCommentCount;
    Post post;


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_post);
        initializeViews();
        setupPostInfo();
        setupComentariosList();
        CarregarComentarios();

    }

    private void initializeViews(){
        rvComments  = findViewById(R.id.rvComments);
        ivProfilePicture  = findViewById(R.id.ivProfilePicture);
        tvUsername   = findViewById(R.id.tvUsername);
        tvData  = findViewById(R.id.tvData);
        tvTexto  = findViewById(R.id.tvTexto);
        tvLikeCount  = findViewById(R.id.tvLikeCount);
        tvCommentCount  = findViewById(R.id.tvCommentCount);
        tvBigCommentCount = findViewById(R.id.tvBigCommentCount);

    }

    private void setupComentariosList() {
        comentarioAdapter = new ComentarioAdapter();
        rvComments.setLayoutManager(new GridLayoutManager(this, 1));
        rvComments.setAdapter(comentarioAdapter);
    }

    private void setupPostInfo(){
        post = (Post) getIntent().getSerializableExtra("post");
        this.tvUsername.setText(post.getUsername());
        this.tvData.setText(post.getDt_postagem());
        this.tvTexto.setText(post.getTexto_post());
        this.tvLikeCount.setText(String.valueOf(post.getLike_count()));
        this.tvCommentCount.setText(String.valueOf(post.getComment_count()));
        String CommentCount = String.valueOf(post.getComment_count()) + " Comentários";
        this.tvBigCommentCount.setText(CommentCount);
        String userPfp = ApiConfig.BASE_URL + "/" + post.getImage();
        Glide.with(this)
                .load(userPfp)
                .into(ivProfilePicture);
    }

    private void CarregarComentarios() {
        SharedPreferences prefs = getSharedPreferences("app_session", MODE_PRIVATE);
        String jwt = prefs.getString("jwt", null);

        Request request = new Request.Builder()
                .url(ApiConfig.POSTS_URL + "/" + post.getId() + "/comentarios")
                .get()
                .addHeader("Authorization", "Bearer " + jwt)
                .build();

        client.newCall(request).enqueue(new Callback() {
            @Override
            public void onFailure(Call call, IOException e) {
                runOnUiThread(() -> Toast.makeText(PostActivity.this, "Erro: "+ e.getMessage(), Toast.LENGTH_SHORT).show());
            }

            @Override
            public void onResponse(Call call, Response response) throws IOException {
                String responseBody = response.body() != null ? response.body().string() : "";

                try{
                    CommentResponse commentResponse = gson.fromJson(responseBody, CommentResponse.class);

                    if (commentResponse != null && commentResponse.isSuccess()) {
                        List<Comentario> comentarios = commentResponse.getData().getComentarios();
                        runOnUiThread(() -> {
                            comentarioAdapter.submitList(comentarios);
                        });
                    } else {
                        runOnUiThread(() -> Toast.makeText(PostActivity.this, "Resposta inválida", Toast.LENGTH_SHORT).show());
                    }

                } catch (Exception e) {
                    runOnUiThread(() -> Toast.makeText(PostActivity.this, "Erro ao converter JSON:\n" + e.getMessage(), Toast.LENGTH_SHORT).show());
                }
            }
        });
    }
}

