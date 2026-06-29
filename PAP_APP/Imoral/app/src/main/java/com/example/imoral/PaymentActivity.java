package com.example.imoral;

import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.ImageButton;
import android.widget.RadioGroup;
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

import com.example.imoral.adapters.CarrinhoAdapter;
import com.example.imoral.adapters.PedidoProdutoAdapter;
import com.example.imoral.models.Carrinhos.AdicionarCarrinhoResponse;
import com.example.imoral.models.Forum.PostarResponse;
import com.example.imoral.models.Pedidos.CheckoutResponse;
import com.example.imoral.models.ProdutoCarrinho;
import com.google.gson.Gson;
import com.google.gson.reflect.TypeToken;

import org.json.JSONException;
import org.json.JSONObject;

import java.io.IOException;
import java.util.List;
import java.util.Objects;

import okhttp3.Call;
import okhttp3.Callback;
import okhttp3.MediaType;
import okhttp3.OkHttpClient;
import okhttp3.Request;
import okhttp3.RequestBody;
import okhttp3.Response;
import utils.ApiConfig;

public class PaymentActivity extends AppCompatActivity {

    private final OkHttpClient client = new OkHttpClient();
    private RecyclerView rvCarrinho;
    private PedidoProdutoAdapter pedidoProdutoAdapter;
    private List<ProdutoCarrinho> produtos;
    private ConstraintLayout layoutDados, btnBack;
    private TextView tvNome, tvTelefone, tvMorada, tvEndereco, tvTotal, tvPreco, tvFrete;
    private Double valorTotal, valorPreco, valorFrete = 2.50;
    private Button btnComprar;
    private String metodoPagamento = "", moradaEntrega = "";
    RadioGroup groupPagamento;
    Gson gson = new Gson();

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        EdgeToEdge.enable(this);
        setContentView(R.layout.activity_payment);
        ViewCompat.setOnApplyWindowInsetsListener(findViewById(R.id.main), (v, insets) -> {
            Insets systemBars = insets.getInsets(WindowInsetsCompat.Type.systemBars());
            v.setPadding(systemBars.left, systemBars.top, systemBars.right, systemBars.bottom);
            return insets;
        });
        String produtosJson = getIntent().getStringExtra("produtos");
        valorPreco = getIntent().getDoubleExtra("valor_total",0);

        produtos = gson.fromJson(produtosJson, new TypeToken<List<ProdutoCarrinho>>(){}.getType());
        initializeViews();
        setupProdutosList();
        listeners();

    }

    private void initializeViews() {
        layoutDados = findViewById(R.id.layoutDados);
        tvNome = findViewById(R.id.tvNome);
        tvTelefone = findViewById(R.id.tvTelefone);
        tvMorada = findViewById(R.id.tvMorada);
        tvEndereco = findViewById(R.id.tvEndereco);
        tvTotal = findViewById(R.id.tvTotal);
        tvPreco = findViewById(R.id.tvPreco);
        tvFrete = findViewById(R.id.tvFrete);
        btnComprar = findViewById(R.id.btnComprar);
        groupPagamento = findViewById(R.id.groupPagamento);
        btnBack = findViewById(R.id.header);
    }


    private void setupProdutosList() {
        pedidoProdutoAdapter = new PedidoProdutoAdapter();
        rvCarrinho = findViewById(R.id.rvCarrinho);
        rvCarrinho.setLayoutManager(new GridLayoutManager(this, 1));
        rvCarrinho.setAdapter(pedidoProdutoAdapter);
        pedidoProdutoAdapter.submitList(produtos);
        String carrinhoPrecoFormat = String.format("%.2f€", valorPreco);
        String fretePrecoFormat = String.format("%.2f€", valorFrete);
        valorTotal = valorFrete + valorPreco;
        String totalPrecoFormat = String.format("%.2f€", valorTotal);
        tvPreco.setText(carrinhoPrecoFormat);
        tvFrete.setText(fretePrecoFormat);
        tvTotal.setText(totalPrecoFormat);
    }

    private void listeners() {

        btnBack.setOnClickListener(v -> finish());

        groupPagamento.setOnCheckedChangeListener((group, checkedId) -> {
            if (checkedId == R.id.btnCreditCard) {
                metodoPagamento = "Cartão de Crédito";
            } else if (checkedId == R.id.btnPaypal) {
                metodoPagamento = "Paypal";
            } else if (checkedId == R.id.btnMbWay) {
                metodoPagamento = "MB WAY";
            }
        });

        btnComprar.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                if(Objects.equals(metodoPagamento, "") || Objects.equals(moradaEntrega, "")){
                    Toast.makeText(PaymentActivity.this, "Preencha os dados de Entrega e de Pagamento", Toast.LENGTH_SHORT).show();
                } else {
                    CheckOut();
                }

            }
        });

        layoutDados.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                EntregaBottomSheet bottomSheet = EntregaBottomSheet.newInstance();

                bottomSheet.setOnEntregaConfirmadaListener((nomeContato,  numTelefoneCompleto,  morada,  endereco, salvar) -> {
                    tvNome.setText(nomeContato);
                    tvTelefone.setText(numTelefoneCompleto);
                    tvMorada.setText(morada);
                    tvEndereco.setText(endereco);
                    moradaEntrega = endereco + morada;
                });

                bottomSheet.show(getSupportFragmentManager(), "EntregaBottomSheet");
            }
        });
    }

    private void CheckOut(){
        SharedPreferences prefs = getSharedPreferences("app_session", MODE_PRIVATE);
        String jwt = prefs.getString("jwt", null);
        int UserId = prefs.getInt("user_id", 0);
        int CarrinhoId = prefs.getInt("carrinho_id", 0);


        JSONObject jsonBody = new JSONObject();
        try {
            jsonBody.put("carrinho_id", CarrinhoId);
            jsonBody.put("id_utilizador", UserId);
            jsonBody.put("metodo_pagamento", metodoPagamento);
            jsonBody.put("valor", valorTotal);
            jsonBody.put("morada_entrega", moradaEntrega);
            jsonBody.put("metodo_envio", "Correio Normal");
            jsonBody.put("entregadora", "CTT");
            jsonBody.put("peso", 1.20);
        } catch (JSONException e) {
            e.printStackTrace();
            return;
        }

        RequestBody body = RequestBody.create(
                jsonBody.toString(),
                MediaType.parse("application/json")
        );

        Request request = new Request.Builder()
                .url(ApiConfig.CHECKOUT_URL)
                .post(body)
                .addHeader("Authorization", "Bearer " + jwt)
                .build();

        client.newCall(request).enqueue(new Callback() {
            @Override
            public void onFailure(Call call, IOException e) {
                runOnUiThread(() -> Toast.makeText(PaymentActivity.this, "Erro: " + e.getMessage(), Toast.LENGTH_SHORT).show());
            }

            @Override
            public void onResponse(Call call, Response response) throws IOException {
                String responseBody = response.body() != null ? response.body().string() : "";
                android.util.Log.d("CHECKOUT", "Status: " + response.code() + " | Body: " + responseBody);
                try {
                    CheckoutResponse resp = gson.fromJson(responseBody, CheckoutResponse.class);

                    if (resp != null && resp.isSuccess()) {
                        runOnUiThread(() -> Toast.makeText(PaymentActivity.this, "Compra Efetuada!", Toast.LENGTH_SHORT).show());
                        Intent intent = new Intent(PaymentActivity.this, CarrinhoActivity.class);
                        startActivity(intent);
                        finish();
                    } else {
                        runOnUiThread(() -> Toast.makeText(PaymentActivity.this, "Erro ao efetuar a compra", Toast.LENGTH_SHORT).show());
                    }
                } catch (Exception e) {
                    runOnUiThread(() -> Toast.makeText(PaymentActivity.this, "Erro ao converter JSON:\n" + e.getMessage(), Toast.LENGTH_SHORT).show());
                }
            }
        });
    }


}