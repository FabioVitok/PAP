package com.example.imoral;

import android.os.Bundle;
import android.widget.ImageView;
import android.widget.TextView;

import androidx.activity.EdgeToEdge;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.graphics.Insets;
import androidx.core.view.ViewCompat;
import androidx.core.view.WindowInsetsCompat;

public class ProdutosActivity extends AppCompatActivity {

    ImageView prodImg;
    TextView prodNome;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        EdgeToEdge.enable(this);
        setContentView(R.layout.activity_produto);
        ViewCompat.setOnApplyWindowInsetsListener(findViewById(R.id.main), (v, insets) -> {
            Insets systemBars = insets.getInsets(WindowInsetsCompat.Type.systemBars());
            v.setPadding(systemBars.left, systemBars.top, systemBars.right, systemBars.bottom);
            return insets;
        });

        String prodNome = getIntent().getStringExtra("prodNome");
        int prodImg = getIntent().getIntExtra("prodImg", 0);

        this.prodImg = findViewById(R.id.ImagemProduto);
        this.prodNome = findViewById(R.id.NomeProduto);

        this.prodImg.setImageResource(prodImg);
        this.prodNome.setText(prodNome);
    }
}