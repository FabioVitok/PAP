package com.example.imoral;

import android.content.SharedPreferences;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.ImageView;
import android.widget.TextView;
import android.widget.Toast;

import androidx.appcompat.app.AppCompatActivity;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import com.bumptech.glide.Glide;
import com.example.imoral.adapters.TamanhoAdapter;
import com.example.imoral.models.Carrinhos.AdicionarCarrinhoResponse;
import com.example.imoral.models.Produto;
import com.example.imoral.models.ProdutoPai;
import com.example.imoral.models.Size.SizeResponse;
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

public class ProdutoActivity extends AppCompatActivity {

    private final OkHttpClient client = new OkHttpClient();
    private final Gson gson = new Gson();
    private TamanhoAdapter TamanhoAdapter;
    private RecyclerView rv;
    private List<Produto> produtos = new ArrayList<>();
    private ProdutoPai produto;
    ImageView ivProduto;
    TextView tvNome;
    TextView tvPrice;
    Button btnAddToCart;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_produto);

        this.produto = (ProdutoPai) getIntent().getSerializableExtra("ProdutoPai");

        this.ivProduto = findViewById(R.id.ImagemProduto);
        this.tvNome = findViewById(R.id.NomeProduto);
        this.tvPrice = findViewById(R.id.tvPrice);
        this.btnAddToCart = findViewById(R.id.btnAddToCart);

        String produtoImg = ApiConfig.BASE_URL + "/" + produto.getImage();

        Glide.with(this)
                .load(produtoImg)
                .into(ivProduto);

        this.tvNome.setText(produto.getNome());
        this.tvPrice.setText(String.format("%.2f€", produto.getPreco_venda()));

        this.rv = findViewById(R.id.rvTamanhos);

        int idPordutoPai = produto.getId();
        setupTamanhosList();
        CarregarProdutos(idPordutoPai);

        btnAddToCart.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                // Chama o metodo RealizarCompra para abrir o bottom sheet de compra
                AdicionarProdutoCarrinho();
            }
        });
    }

    private void setupTamanhosList() {
        TamanhoAdapter = new TamanhoAdapter(R.layout.item_tamanho);

        LinearLayoutManager layoutManager
                = new LinearLayoutManager(this, LinearLayoutManager.HORIZONTAL, false);
        rv.setLayoutManager(layoutManager);
        rv.setAdapter(TamanhoAdapter);
    }

    private void CarregarProdutos(int idProdutoPai) {
        SharedPreferences prefs = getSharedPreferences("app_session", MODE_PRIVATE);
        String jwt = prefs.getString("jwt", null);

        Request request = new Request.Builder()
                .url(ApiConfig.SIZES_URL + idProdutoPai)
                .get()
                .addHeader("Authorization", "Bearer " + jwt)
                .build();

        client.newCall(request).enqueue(new Callback() {
            @Override
            public void onFailure(Call call, IOException e) {
                runOnUiThread(() -> Toast.makeText(ProdutoActivity.this, "Erro: " + e.getMessage(), Toast.LENGTH_SHORT).show());
            }

            @Override
            public void onResponse(Call call, Response response) throws IOException {
                String responseBody = response.body() != null ? response.body().string() : "";

                try {
                    SizeResponse SizeResponse = gson.fromJson(responseBody, SizeResponse.class);

                    if (SizeResponse != null && SizeResponse.isSuccess()) {
                        produtos = SizeResponse.getData().getProdutos();
                        runOnUiThread(() -> {
                            TamanhoAdapter.submitList(produtos);
                        });
                    } else {
                        runOnUiThread(() -> Toast.makeText(ProdutoActivity.this, "Resposta inválida", Toast.LENGTH_SHORT).show());
                    }

                } catch (Exception e) {
                    runOnUiThread(() -> Toast.makeText(ProdutoActivity.this, "Erro ao converter JSON:\n" + e.getMessage(), Toast.LENGTH_SHORT).show());
                }
            }
        });
    }

    public void AdicionarProdutoCarrinho() {
        int position = TamanhoAdapter.getSelectedPosition();
        CompraBottomSheet bottomSheet = CompraBottomSheet.newInstance(produto, produtos, position);

        bottomSheet.setOnCompraListener((quantidadeRecebida, idProdutoSelecionado) -> {
            AdicionarItemCarrinho(idProdutoSelecionado, quantidadeRecebida);
        });

        bottomSheet.show(getSupportFragmentManager(), "CompraBottomSheet");
    }

    private void AdicionarItemCarrinho(int idProduto, int quantidade) {
        SharedPreferences prefs = getSharedPreferences("app_session", MODE_PRIVATE);
        String jwt = prefs.getString("jwt", null);
        int idCarrinho = prefs.getInt("carrinho_id", -1);


        JSONObject jsonBody = new JSONObject();
        try {
            jsonBody.put("id_carrinho", idCarrinho);
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
                .url(ApiConfig.CARRINHO_PRODUTO_URL)
                .post(body)
                .addHeader("Authorization", "Bearer " + jwt)
                .build();

        client.newCall(request).enqueue(new Callback() {
            @Override
            public void onFailure(Call call, IOException e) {
                runOnUiThread(() -> Toast.makeText(ProdutoActivity.this, "Erro: " + e.getMessage(), Toast.LENGTH_SHORT).show());
            }

            @Override
            public void onResponse(Call call, Response response) throws IOException {
                String responseBody = response.body() != null ? response.body().string() : "";
                android.util.Log.d("ADD_CARRINHO", "Status: " + response.code() + " | Body: " + responseBody);
                try {
                    AdicionarCarrinhoResponse resp = gson.fromJson(responseBody, AdicionarCarrinhoResponse.class);

                    if (resp != null && resp.isSuccess()) {
                        runOnUiThread(() -> Toast.makeText(ProdutoActivity.this, "Adicionado ao carrinho!", Toast.LENGTH_SHORT).show());
                    } else {
                        runOnUiThread(() -> Toast.makeText(ProdutoActivity.this, "Erro ao adicionar produto", Toast.LENGTH_SHORT).show());
                    }
                } catch (Exception e) {
                    runOnUiThread(() -> Toast.makeText(ProdutoActivity.this, "Erro ao converter JSON:\n" + e.getMessage(), Toast.LENGTH_SHORT).show());
                }
            }
        });
    }
}