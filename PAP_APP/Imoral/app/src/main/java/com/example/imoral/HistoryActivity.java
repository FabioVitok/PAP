package com.example.imoral;

import android.content.SharedPreferences;
import android.os.Bundle;
import android.widget.Toast;

import androidx.activity.EdgeToEdge;
import androidx.appcompat.app.AppCompatActivity;
import androidx.constraintlayout.widget.ConstraintLayout;
import androidx.core.graphics.Insets;
import androidx.core.view.ViewCompat;
import androidx.core.view.WindowInsetsCompat;
import androidx.recyclerview.widget.GridLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import com.example.imoral.adapters.CarrinhoAdapter;
import com.example.imoral.adapters.PedidoAdapter;
import com.example.imoral.models.Carrinhos.CarrinhoResponse;
import com.example.imoral.models.Forum.ForumResponse;
import com.example.imoral.models.Pedido;
import com.example.imoral.models.Pedidos.PedidosResponse;
import com.example.imoral.models.Post;
import com.example.imoral.models.ProdutoCarrinho;
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

public class HistoryActivity extends AppCompatActivity {

    private final OkHttpClient client = new OkHttpClient();
    Gson gson = new Gson();
    RecyclerView rvPedidos;
    ConstraintLayout btnBack;
    private PedidoAdapter pedidoAdapter;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        EdgeToEdge.enable(this);
        setContentView(R.layout.activity_history);
        ViewCompat.setOnApplyWindowInsetsListener(findViewById(R.id.main), (v, insets) -> {
            Insets systemBars = insets.getInsets(WindowInsetsCompat.Type.systemBars());
            v.setPadding(systemBars.left, systemBars.top, systemBars.right, systemBars.bottom);
            return insets;
        });
        initializeViews();
        listeners();
        setupPedidosList();
        carregarPedidos();
    }

    private void setupPedidosList() {
        pedidoAdapter = new PedidoAdapter();
        rvPedidos.setLayoutManager(new GridLayoutManager(this, 1));
        rvPedidos.setAdapter(pedidoAdapter);
    }

    private void initializeViews() {
        rvPedidos = findViewById(R.id.rvPedidos);
        btnBack = findViewById(R.id.header);
    }

    private void listeners() {
        btnBack.setOnClickListener(v -> finish());


    }

    private void carregarPedidos() {
        SharedPreferences prefs = getSharedPreferences("app_session", MODE_PRIVATE);
        String jwt = prefs.getString("jwt", null);
        int userId = prefs.getInt("user_id", -1);

        Request request = new Request.Builder()
                .url(ApiConfig.CHECKOUT_URL + "/" + userId)
                .get()
                .addHeader("Authorization", "Bearer " + jwt)
                .build();

        client.newCall(request).enqueue(new Callback() {
            @Override
            public void onFailure(Call call, IOException e) {
                runOnUiThread(() -> Toast.makeText(HistoryActivity.this, "Erro: " + e.getMessage(), Toast.LENGTH_SHORT).show());
            }
            @Override
            public void onResponse(Call call, Response response) throws IOException {
                String responseBody = response.body() != null ? response.body().string() : "";
                android.util.Log.d("CHECKOUT", "Status: " + response.code() + " | Body: " + responseBody);
                try{
                    PedidosResponse pedidosResponse = gson.fromJson(responseBody, PedidosResponse.class);

                    if (pedidosResponse != null && pedidosResponse.isSuccess()) {
                        List<Pedido> pedidos = pedidosResponse.getData().getPedidos();
                        runOnUiThread(() -> {
                            pedidoAdapter.submitList(pedidos);
                        });
                    } else {
                        runOnUiThread(() -> Toast.makeText(HistoryActivity.this, "Resposta inválida", Toast.LENGTH_SHORT).show());
                    }

                } catch (Exception e) {
                    runOnUiThread(() -> Toast.makeText(HistoryActivity.this, "Erro ao converter JSON:\n" + e.getMessage(), Toast.LENGTH_SHORT).show());
                }
            }
        });
    }
}