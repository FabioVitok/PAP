package com.example.imoral;

import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.view.View;
import android.widget.ImageView;
import android.widget.TextView;
import android.widget.Toast;

import androidx.appcompat.app.AppCompatActivity;
import androidx.constraintlayout.widget.ConstraintLayout;
import androidx.recyclerview.widget.GridLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import com.bumptech.glide.Glide;
import com.bumptech.glide.load.engine.DiskCacheStrategy;
import com.example.imoral.adapters.ComentarioAdapter;
import com.example.imoral.models.Comentario;
import com.example.imoral.models.Comments.CommentResponse;
import com.example.imoral.models.Forum.PostarResponse;
import com.example.imoral.models.Post;
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

public class PostActivity extends AppCompatActivity {

    private final OkHttpClient client = new OkHttpClient();
    private final Gson gson = new Gson();
    private ComentarioAdapter comentarioAdapter;
    private RecyclerView rvComments;
    private int globalCommentCount, idComentarioPai = 0;
    ImageView ivProfilePicture, ivProfilePictureBottomSheet;
    TextView tvUsername, tvData, tvTexto, tvLikeCount, tvCommentCount, tvBigCommentCount;
    ConstraintLayout btnComment, btnBack;
    Post post;


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_post);
        post = (Post) getIntent().getSerializableExtra("post");
        initializeViews();
        setupPostInfo();
        setupComentariosList();
        CarregarComentarios();
        listeners();
    }

    private void initializeViews(){
        rvComments  = findViewById(R.id.rvComments);
        ivProfilePicture  = findViewById(R.id.ivProfilePicture);
        ivProfilePictureBottomSheet  = findViewById(R.id.ivProfilePictureBottomSheet);
        tvUsername   = findViewById(R.id.tvUsername);
        tvData  = findViewById(R.id.tvData);
        tvTexto  = findViewById(R.id.tvTexto);
        tvLikeCount  = findViewById(R.id.tvLikeCount);
        tvCommentCount  = findViewById(R.id.tvCommentCount);
        tvBigCommentCount = findViewById(R.id.tvBigCommentCount);
        btnComment = findViewById(R.id.btnComment);
        btnBack = findViewById(R.id.header);
    }

    private void listeners(){
        SharedPreferences prefs = getSharedPreferences("app_session", MODE_PRIVATE);
        String username = prefs.getString("username", null);
        String image = prefs.getString("image", null);
        String userPfp = ApiConfig.BASE_URL + "/" + image;
        Glide.with(this)
                .load(userPfp)
                .diskCacheStrategy(DiskCacheStrategy.NONE)
                .skipMemoryCache(true)
                .into(ivProfilePictureBottomSheet);

        btnComment.setOnClickListener(v -> {
            openBottomSheet(idComentarioPai);
        });

        btnBack.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                finish();
            }
        });
    }

    private void openBottomSheet(int idComentarioPai){
        SharedPreferences prefs = getSharedPreferences("app_session", MODE_PRIVATE);
        String username = prefs.getString("username", null);
        String image = prefs.getString("image", null);
        PostFragment postFragment = PostFragment.newInstance(username,image);

        postFragment.setOnPostListener(texto -> {
            CriarComentario(texto, idComentarioPai);
        });

        postFragment.show(getSupportFragmentManager(), "post_fragment");
    }


    private void setupComentariosList() {
        comentarioAdapter = new ComentarioAdapter(comentario -> CarregarRespostas(comentario),
                idComentarioPai-> openBottomSheet(idComentarioPai));
        rvComments.setLayoutManager(new GridLayoutManager(this, 1));
        rvComments.setAdapter(comentarioAdapter);
    }

    private void setupPostInfo(){
        post = (Post) getIntent().getSerializableExtra("post");
        globalCommentCount = post.getComment_count();
        this.tvUsername.setText(post.getUsername());
        this.tvData.setText(post.getDt_postagem());
        this.tvTexto.setText(post.getTexto_post());
        this.tvLikeCount.setText(String.valueOf(post.getLike_count()));
        this.tvCommentCount.setText(String.valueOf(globalCommentCount));
        String CommentCount = globalCommentCount + " Comentários";
        this.tvBigCommentCount.setText(CommentCount);
        String userPfp = ApiConfig.BASE_URL + "/" + post.getImage();
        Glide.with(this)
                .load(userPfp)
                .into(ivProfilePicture);

    }

    private void updateCommentCountUI() {
        this.tvCommentCount.setText(String.valueOf(globalCommentCount));
        this.tvBigCommentCount.setText(globalCommentCount + " Comentários");
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
                            comentarioAdapter.submitList(null);
                            comentarioAdapter.submitList(new ArrayList<>(comentarios));
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

    private void CarregarRespostas(Comentario comentario) {
        SharedPreferences prefs = getSharedPreferences("app_session", MODE_PRIVATE);
        String jwt = prefs.getString("jwt", null);
        int comentarioId = comentario.getId();

        Request request = new Request.Builder()
                .url(ApiConfig.COMENTARIO_URL + "/" + comentarioId + "/respostas")
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
                        List<Comentario> respostas = commentResponse.getData().getComentarios();
                        runOnUiThread(() -> {
                            comentarioAdapter.submitRespostasList(comentarioId, new ArrayList<>(respostas));
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

    private void CriarComentario(String texto, int idComentarioPai) {
        SharedPreferences prefs = getSharedPreferences("app_session", MODE_PRIVATE);
        String jwt = prefs.getString("jwt", null);
        JSONObject jsonBody = new JSONObject();
        if(idComentarioPai == 0) {
            try {
                jsonBody.put("texto_comentario", texto);
                jsonBody.put("id_comentario_pai", null);
            } catch (JSONException e) {
                e.printStackTrace();
                return;
            }
        } else {
            try {
                jsonBody.put("texto_comentario", texto);
                jsonBody.put("id_comentario_pai", idComentarioPai);
            } catch (JSONException e) {
                e.printStackTrace();
                return;
            }
        }

        RequestBody body = RequestBody.create(
                jsonBody.toString(),
                MediaType.parse("application/json")
        );

        Request request = new Request.Builder()
                .url(ApiConfig.POSTS_URL + "/" + post.getId() + "/comentarios")
                .post(body)
                .addHeader("Authorization", "Bearer " + jwt)
                .build();

        client.newCall(request).enqueue(new Callback() {
            @Override
            public void onFailure(Call call, IOException e) {
                runOnUiThread(() -> Toast.makeText(PostActivity.this, "Erro: " + e.getMessage(), Toast.LENGTH_SHORT).show());
            }

            @Override
            public void onResponse(Call call, Response response) throws IOException {
                String responseBody = response.body() != null ? response.body().string() : "";
                android.util.Log.d("POSTAR", "Status: " + response.code() + " | Body: " + responseBody);
                try {
                    PostarResponse resp = gson.fromJson(responseBody, PostarResponse.class);

                    if (resp != null && resp.isSuccess()) {
                        globalCommentCount++;
                        runOnUiThread(() -> {
                            Toast.makeText(PostActivity.this, "Comentário Feito", Toast.LENGTH_SHORT).show();
                            updateCommentCountUI();
                        });
                        CarregarComentarios();
                    } else {
                        runOnUiThread(() -> Toast.makeText(PostActivity.this, "Erro ao Comentar", Toast.LENGTH_SHORT).show());
                    }
                } catch (Exception e) {
                    runOnUiThread(() -> Toast.makeText(PostActivity.this, "Erro ao converter JSON:\n" + e.getMessage(), Toast.LENGTH_SHORT).show());
                }
            }
        });
    }
}

