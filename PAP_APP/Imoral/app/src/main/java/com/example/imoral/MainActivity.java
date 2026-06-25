package com.example.imoral;

import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.view.View;
import android.widget.ImageButton;
import android.widget.Toast;

import androidx.appcompat.app.AppCompatActivity;
import androidx.recyclerview.widget.GridLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import com.example.imoral.models.Home.HomeResponse;
import com.example.imoral.models.ProdutoPai;

import java.util.ArrayList;
import java.util.List;

import com.example.imoral.adapters.ProdutoAdapter;
import com.google.gson.Gson;

import java.io.IOException;

import okhttp3.Call;
import okhttp3.Callback;
import okhttp3.OkHttpClient;
import okhttp3.Request;
import okhttp3.Response;
import utils.ApiConfig;
public class MainActivity extends AppCompatActivity {


    private final OkHttpClient client = new OkHttpClient();
    private final Gson gson = new Gson();

    private ProdutoAdapter produtoAdapter;
    private RecyclerView rvProdutos;
    private ImageButton imageButtonForum;
    private ImageButton imageButtonCarrinho;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        setupProdutosList();
        CarregarProdutos();

        imageButtonForum = findViewById(R.id.imageButtonForum);
        imageButtonForum.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent intent = new Intent(MainActivity.this, ForumActivity.class);
                startActivity(intent);
            }
        });



        imageButtonCarrinho = findViewById(R.id.imageButtonCarrinho);
        imageButtonCarrinho.setOnClickListener(new View.OnClickListener() {
        @Override
        public void onClick(View v) {
            Intent intent = new Intent(MainActivity.this, CarrinhoActivity.class);
            startActivity(intent);
        }
    });

}

    private void setupProdutosList() {
        produtoAdapter = new ProdutoAdapter();
        rvProdutos = findViewById(R.id.rvProducts);
        rvProdutos.setLayoutManager(new GridLayoutManager(this, 2));
        rvProdutos.setAdapter(produtoAdapter);
    }
    private void CarregarProdutos() {
        List<ProdutoPai> produtos = new ArrayList<>();
        SharedPreferences prefs = getSharedPreferences("app_session", MODE_PRIVATE);
        String jwt = prefs.getString("jwt", null);

        Request request = new Request.Builder()
                .url(ApiConfig.HOME_URL)
                .get()
                .addHeader("Authorization", "Bearer " + jwt)
                .build();

        client.newCall(request).enqueue(new Callback() {
            @Override
            public void onFailure(Call call, IOException e) {
                runOnUiThread(() -> Toast.makeText(MainActivity.this, "Erro: "+ e.getMessage(), Toast.LENGTH_SHORT).show());
            }

            @Override
            public void onResponse(Call call, Response response) throws IOException {
                    String responseBody = response.body() != null ? response.body().string() : "";

                    try{
                        HomeResponse homeResponse = gson.fromJson(responseBody, HomeResponse.class);

                        if (homeResponse != null && homeResponse.isSuccess()) {
                            List<ProdutoPai> produtos = homeResponse.getData().getProdutos();
                            runOnUiThread(() -> {
                                produtoAdapter.submitList(produtos);
                            });
                        } else {
                            runOnUiThread(() -> Toast.makeText(MainActivity.this, "Resposta inválida", Toast.LENGTH_SHORT).show());
                        }

                    } catch (Exception e) {
                        runOnUiThread(() -> Toast.makeText(MainActivity.this, "Erro ao converter JSON:\n" + e.getMessage(), Toast.LENGTH_SHORT).show());
                    }
            }
        });
    }
}