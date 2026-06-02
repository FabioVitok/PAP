package com.example.imoral;

import android.os.Bundle;

import androidx.activity.EdgeToEdge;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.graphics.Insets;
import androidx.core.view.ViewCompat;
import androidx.core.view.WindowInsetsCompat;
import androidx.recyclerview.widget.GridLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import com.example.imoral.adapters.PostAdapter;
import com.example.imoral.adapters.ProdutoAdapter;
import com.example.imoral.models.Acessorio;
import com.example.imoral.models.Post;
import com.example.imoral.models.Produto;
import com.example.imoral.models.Utilizador;

import java.util.ArrayList;
import java.util.List;

public class ForumActivity extends AppCompatActivity {

    private PostAdapter postAdapter;
    private RecyclerView rvPosts;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_forum);

        this.rvPosts = findViewById(R.id.rvPosts);
        setupPostsList();
        }

        private void setupPostsList() {
            postAdapter = new PostAdapter();
            rvPosts.setLayoutManager(new GridLayoutManager(this, 1));
            rvPosts.setAdapter(postAdapter);
            Utilizador jpeg = new Utilizador (1, "JPEGMAFIA", "jp@gmail", "jpegmafia", "User", "967140012", "AMHAC", "Vialonga", "Hoje");
            Utilizador mana = new Utilizador (2, "Mana Sama", "manabu@gmail", "mana", "User", "967140012", "malice", "Vialonga", "Hoje");
            List<Post> Posts = new ArrayList<>();
            Posts.add(new Post(1, jpeg, "25 Dec 2025", "O meu ultimo album foi mau"));
            Posts.add(new Post(2, mana, "24 Dec 2025", "O album do jpegmafia foi mau"));
            Posts.add(new Post(2, mana, "24 Dec 2025", "マリスミゼル「エーゲ海に捧」羅馬拼音歌詞"));
            postAdapter.submitList(Posts);

        }
    }
