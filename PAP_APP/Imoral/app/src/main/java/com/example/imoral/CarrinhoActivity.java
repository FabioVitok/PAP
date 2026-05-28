package com.example.imoral;

import android.os.Bundle;

import androidx.appcompat.app.AppCompatActivity;
import androidx.recyclerview.widget.GridLayoutManager;
import androidx.recyclerview.widget.RecyclerView;
import com.example.imoral.models.Acessorio;
import com.example.imoral.models.Produto;
import com.example.imoral.models.Carrinho;
import com.example.imoral.models.ProdutoCarrinho;
import com.example.imoral.models.Roupa;
import com.example.imoral.models.Utilizador;

import java.util.ArrayList;
import java.util.List;

import com.example.imoral.adapters.CarrinhoAdapter;

public class CarrinhoActivity extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_carrinho);

        // Lista de produtos
        List<Produto> produtos = new ArrayList<>();
        produtos.add(new Acessorio(1, "Eyelet Lace Bag", "preto", "Tamanho Unico", R.drawable.eyeletbag, 25, 0.60, 27.99 , 12.00));
        produtos.add(new Roupa(2, "Flared Distressed Jeans", "preto", "m", R.drawable.flaredjeans,25, 0.90, 29.99 , 15.00));
        produtos.add(new Roupa(3, "Pierced Shoulder Off", "preto", "m", R.drawable.piercedshoulder,25, 0.60, 25.99 , 13.00));
        produtos.add(new Acessorio(4, "Eyelet Kerchief", "preto", "m", R.drawable.eyeletkerchief,25, 0.50, 15.99 , 7.00));
        produtos.add(new Acessorio(5, "Lace Belt", "preto", "Tamanho unico", R.drawable.lacebelt,25, 0.70, 15.99 , 7.00));
        produtos.add(new Roupa(6, "Pierced Shirt", "preto", "m", R.drawable.piercedshirt,25, 34.00, 35.99 , 20.00));
        produtos.add(new Acessorio(1, "Eyelet Lace Bag", "preto", "Tamanho Unico", R.drawable.eyeletbag, 25, 0.60, 27.99 , 12.00));
        produtos.add(new Roupa(2, "Flared Distressed Jeans", "preto", "m", R.drawable.flaredjeans,25, 0.90, 29.99 , 15.00));
        produtos.add(new Roupa(3, "Pierced Shoulder Off", "preto", "m", R.drawable.piercedshoulder,25, 0.60, 25.99 , 13.00));
        produtos.add(new Acessorio(4, "Eyelet Kerchief", "preto", "m", R.drawable.eyeletkerchief,25, 0.50, 15.99 , 7.00));
        produtos.add(new Acessorio(5, "Lace Belt", "preto", "Tamanho unico", R.drawable.lacebelt,25, 0.70, 15.99 , 7.00));
        produtos.add(new Roupa(6, "Pierced Shirt", "preto", "m", R.drawable.piercedshirt,25, 34.00, 35.99 , 20.00));

        new ProdutoCarrinho(produtos.get(1),2);

        Carrinho carro = new Carrinho(1, new Utilizador(1, "josé", "er@gmail", 3, "User", "967140012", "Fabios", "Vialonga", "Hoje"));
        ProdutoCarrinho p1 = new ProdutoCarrinho(new Roupa(2, "Flared Distressed Jeans", "preto", "m", R.drawable.flaredjeans, 25, 0.90, 29.99, 15.00), 4);
        carro.getProdutosCarrinho().add(p1);

        // RecyclerView — 2 colunas + scroll automático
        RecyclerView rv = findViewById(R.id.rvCarrinho);
        rv.setLayoutManager(new GridLayoutManager(this, 1));
        rv.setAdapter(new CarrinhoAdapter(carro, produto -> {
            // Ação ao clicar num produto
            // ex: abrir o detalhe do produto
        }));
    }
}