package com.example.imoral;

import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.ImageView;
import android.widget.TextView;
import android.widget.Toast;

import androidx.annotation.NonNull;
import androidx.appcompat.app.AppCompatActivity;
import androidx.recyclerview.widget.GridLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import com.bumptech.glide.Glide;
import com.example.imoral.adapters.PostAdapter;
import com.example.imoral.adapters.TamanhoAdapter;
import com.example.imoral.models.Carrinhos.AdicionarCarrinhoResponse;
import com.example.imoral.models.Carrinhos.CarrinhoResponse;
import com.example.imoral.models.Produto;
import com.example.imoral.models.Carrinho;
import com.example.imoral.models.ProdutoCarrinho;
import com.example.imoral.models.Size.SizeResponse;
import com.example.imoral.models.Utilizador;
import com.google.gson.GsonBuilder;
import com.google.gson.JsonDeserializer;

import java.io.IOException;
import java.util.ArrayList;
import java.util.List;

import com.example.imoral.adapters.CarrinhoAdapter;
import com.google.gson.Gson;

import org.json.JSONException;
import org.json.JSONObject;

import okhttp3.Call;
import okhttp3.Callback;
import okhttp3.MediaType;
import okhttp3.OkHttpClient;
import okhttp3.Request;
import okhttp3.RequestBody;
import okhttp3.Response;
import utils.ApiConfig;

public class CarrinhoActivity extends AppCompatActivity {

    private final OkHttpClient client = new OkHttpClient();
    private CarrinhoAdapter CarrinhoAdapter;
    private RecyclerView rvCarrinho;
    private List<ProdutoCarrinho> produtos = new ArrayList<>();
    private TextView tvTotalCarrinho, tvCarrinhoVazio, tvCarrinhoPrice;
    private ImageView ivCarrinhoVazio, btnForum, btnCarrinho, btnUser, btnHome;
    private Button btnComprar;
    private Double custoTotal;
    private int produtosTotal;

    private final Gson gson = new GsonBuilder()
            .registerTypeAdapter(Carrinho.class, (JsonDeserializer<Carrinho>) (json, typeOfT, context) -> {
                if (json.isJsonArray()) {
                    // "data": [] -> carrinho vazio
                    return new Gson().fromJson("{\"produtos\":[]}", Carrinho.class);
                }
                return new Gson().fromJson(json, Carrinho.class);
            })
            .create();

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_carrinho);

        initializeviews();
        setupProdutosList();
        CarregarProdutos();
        listeners();
    }

    private void initializeviews(){
        btnComprar = findViewById(R.id.btnComprar);
        btnComprar.setEnabled(false);
        btnForum = findViewById(R.id.btnForum);
        btnCarrinho = findViewById(R.id.btnCarrinho);
        btnUser = findViewById(R.id.btnUser);
        btnHome = findViewById(R.id.btnHome);
        ivCarrinhoVazio = findViewById(R.id.ivCarrinhoVazio);
        tvCarrinhoVazio = findViewById(R.id.tvCarrinhoVazio);
        tvTotalCarrinho = findViewById(R.id.tvTotalCarrinho);
        tvCarrinhoPrice = findViewById(R.id.tvCarrinhoPrice);
    }

    private void listeners(){
        btnComprar.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent intent = new Intent(CarrinhoActivity.this, PaymentActivity.class);
                Gson gson = new Gson();
                String produtosJson = gson.toJson(produtos);
                intent.putExtra("produtos", produtosJson);
                intent.putExtra("valor_total", custoTotal);
                startActivity(intent);
            }
        });
        btnHome.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent intent = new Intent(CarrinhoActivity.this, MainActivity.class);
                startActivity(intent);
                finish();
            }
        });
        btnForum.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent intent = new Intent(CarrinhoActivity.this, ForumActivity.class);
                startActivity(intent);
                finish();
            }
        });

        btnCarrinho.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                mostrarCarrinho();
            }
        });

        btnUser.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent intent = new Intent(CarrinhoActivity.this, UserActivity.class);
                startActivity(intent);
                finish();
            }
        });

    }
    private void totalCarrinho(){
        custoTotal = 0.0;
        produtosTotal = 0;

        for (ProdutoCarrinho produto : produtos) {
            custoTotal = custoTotal + produto.getQuantidade() * produto.getPrecoVenda();
            produtosTotal = produtosTotal + 1 * produto.getQuantidade();
        }
        String TotalPrecoFormat = String.format("%.2f€", custoTotal);
        tvCarrinhoPrice.setText(TotalPrecoFormat);
        tvTotalCarrinho.setText("Carrinho (" + produtosTotal  + ")");
    }

    private void setupProdutosList() {
        CarrinhoAdapter = new CarrinhoAdapter(
                produto -> RemoverProduto(produto),
                (produto, quantidade) -> AlterarQuantidade(produto, quantidade),
                () -> totalCarrinho()
        );
        rvCarrinho = findViewById(R.id.rvCarrinho);
        rvCarrinho.setLayoutManager(new GridLayoutManager(this, 1));
        rvCarrinho.setAdapter(CarrinhoAdapter);
    }

    private void mostrarCarrinhoVazio() {
        rvCarrinho.setVisibility(View.GONE);
        ivCarrinhoVazio.setVisibility(View.VISIBLE);
        tvCarrinhoVazio.setVisibility(View.VISIBLE);
        tvTotalCarrinho.setText("Carrinho (0)");
        btnComprar.setEnabled(false);
    }

    private void mostrarCarrinho() {
        rvCarrinho.setVisibility(View.VISIBLE);
        ivCarrinhoVazio.setVisibility(View.GONE);
        tvCarrinhoVazio.setVisibility(View.GONE);
        btnComprar.setEnabled(true);
    }

    private void CarregarProdutos() {
        SharedPreferences prefs = getSharedPreferences("app_session", MODE_PRIVATE);
        String jwt = prefs.getString("jwt", null);
        int userId = prefs.getInt("user_id", -1);

        Request request = new Request.Builder()
                .url(ApiConfig.CARRINHO_URL + userId)
                .get()
                .addHeader("Authorization", "Bearer " + jwt)
                .build();

        client.newCall(request).enqueue(new Callback() {
            @Override
            public void onFailure(Call call, IOException e) {
                runOnUiThread(() -> Toast.makeText(CarrinhoActivity.this, "Erro: " + e.getMessage(), Toast.LENGTH_SHORT).show());
            }

            @Override
            public void onResponse(Call call, Response response) throws IOException {
                String responseBody = response.body() != null ? response.body().string() : "";

                try {
                    CarrinhoResponse carrinhoResponse = gson.fromJson(responseBody, CarrinhoResponse.class);

                    List<ProdutoCarrinho> lista = (carrinhoResponse != null
                            && carrinhoResponse.isSuccess()
                            && carrinhoResponse.getData() != null
                            && carrinhoResponse.getData().getProdutos() != null)
                            ? carrinhoResponse.getData().getProdutos()
                            : new ArrayList<>();

                    runOnUiThread(() -> {
                        if (lista.isEmpty()) {
                            mostrarCarrinhoVazio();
                        } else {
                            produtos = lista;
                            mostrarCarrinho();
                            CarrinhoAdapter.submitList(produtos);
                            totalCarrinho();
                        }
                    });

                } catch (Exception e) {
                    android.util.Log.e("CARRINHO", "Erro ao converter JSON", e);
                    runOnUiThread(() -> Toast.makeText(CarrinhoActivity.this, "Erro ao carregar carrinho", Toast.LENGTH_SHORT).show());
                }
            }
        });
    }

        private void RemoverProduto(ProdutoCarrinho produto) {
            SharedPreferences prefs = getSharedPreferences("app_session", MODE_PRIVATE);
            String jwt = prefs.getString("jwt", null);

            Request request = new Request.Builder()
                    .url(ApiConfig.CARRINHO_URL + produto.getId())
                    .delete()
                    .addHeader("Authorization", "Bearer " + jwt)
                    .build();

            client.newCall(request).enqueue(new Callback() {
                @Override
                public void onFailure(Call call, IOException e) {
                    runOnUiThread(() -> Toast.makeText(CarrinhoActivity.this, "Erro: " + e.getMessage(), Toast.LENGTH_SHORT).show());
                }

                @Override
                public void onResponse(Call call, Response response) throws IOException {
                    if (response.isSuccessful()) {
                        runOnUiThread(() -> {
                            produtos.remove(produto);
                            CarrinhoAdapter.removeItem(produto);
                            totalCarrinho();
                            Toast.makeText(CarrinhoActivity.this, "Produto removido!", Toast.LENGTH_SHORT).show();
                            if(CarrinhoAdapter.getItemCount() == 0){
                                mostrarCarrinhoVazio();
                            }
                        });
                    } else {
                        runOnUiThread(() -> Toast.makeText(CarrinhoActivity.this, "Erro ao remover produto", Toast.LENGTH_SHORT).show());
                    }
                }
            });
        }

        private void AlterarQuantidade(ProdutoCarrinho produto, int quantidade) {
            SharedPreferences prefs = getSharedPreferences("app_session", MODE_PRIVATE);
            String jwt = prefs.getString("jwt", null);
            int idUser = prefs.getInt("user_id", -1);
            int idProduto = produto.getId();


            JSONObject jsonBody = new JSONObject();
            try {
                jsonBody.put("id_produto", idProduto);
                jsonBody.put("quantidade", quantidade);
            } catch (JSONException e) {
                e.printStackTrace();
                return;
            }

            RequestBody body = RequestBody.create(
                    jsonBody.toString(),
                    MediaType.parse("application/json")
            );

            Request request = new Request.Builder()
                    .url(ApiConfig.CARRINHO_URL + idUser)
                    .patch(body)
                    .addHeader("Authorization", "Bearer " + jwt)
                    .build();

            client.newCall(request).enqueue(new Callback() {
                @Override
                public void onFailure(Call call, IOException e) {
                    runOnUiThread(() -> Toast.makeText(CarrinhoActivity.this, "Erro: " + e.getMessage(), Toast.LENGTH_SHORT).show());
                }

                @Override
                public void onResponse(Call call, Response response) throws IOException {
                    String responseBody = response.body() != null ? response.body().string() : "";
                    android.util.Log.d("ADD_CARRINHO", "Status: " + response.code() + " | Body: " + responseBody);
                    try {
                        AdicionarCarrinhoResponse resp = gson.fromJson(responseBody, AdicionarCarrinhoResponse.class);

                        if (resp != null && resp.isSuccess()) {
                            runOnUiThread(() -> Toast.makeText(CarrinhoActivity.this, "Adicionado ao carrinho!", Toast.LENGTH_SHORT).show());
                        } else {
                            runOnUiThread(() -> Toast.makeText(CarrinhoActivity.this, "Erro ao adicionar produto", Toast.LENGTH_SHORT).show());
                        }
                    } catch (Exception e) {
                        runOnUiThread(() -> Toast.makeText(CarrinhoActivity.this, "Erro ao converter JSON:\n" + e.getMessage(), Toast.LENGTH_SHORT).show());
                    }
                }
            });
        }
    }


