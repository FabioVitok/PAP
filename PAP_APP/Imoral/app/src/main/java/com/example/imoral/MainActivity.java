package com.example.imoral;

import android.os.Bundle;

import androidx.activity.EdgeToEdge;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.graphics.Insets;
import androidx.core.view.ViewCompat;
import androidx.core.view.WindowInsetsCompat;
import androidx.recyclerview.widget.GridLayoutManager;
import androidx.recyclerview.widget.RecyclerView;
import com.example.imoral.models.Acessorio;
import com.example.imoral.models.Produto;
import java.util.ArrayList;
import java.util.List;

public class MainActivity extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        // Lista de produtos
        List<Produto> produtos = new ArrayList<>();
        produtos.add(new Acessorio(1, "Eyelet Lace Bag", "preto", "m", "", 25, 34.00, 25.00 , 12.00));
        produtos.add(new Acessorio(1, "Eyelete Bag", "preto", "m", "" ,25, 34.00, 15.00 , 12.00));


        // RecyclerView — 2 colunas + scroll automático
        RecyclerView rv = findViewById(R.id.rvProducts);
        rv.setLayoutManager(new GridLayoutManager(this, 2));
        rv.setAdapter(new ProdutoAdapter(produtos, produto -> {
            // Ação ao clicar num produto
            // ex: abrir o detalhe do produto
        }));
    }
}