package com.example.imoral;

import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.view.View;
import android.widget.ImageView;
import android.widget.TextView;

import androidx.activity.EdgeToEdge;
import androidx.appcompat.app.AppCompatActivity;
import androidx.constraintlayout.widget.ConstraintLayout;
import androidx.core.graphics.Insets;
import androidx.core.view.ViewCompat;
import androidx.core.view.WindowInsetsCompat;

import com.bumptech.glide.Glide;
import com.bumptech.glide.load.engine.DiskCacheStrategy;

import utils.ApiConfig;

public class UserActivity extends AppCompatActivity {

    ImageView ivProfilePicture, btnForum, btnCarrinho, btnUser, btnHome;
    TextView tvUsername;
    ConstraintLayout btnEdit, btnInfo, btnHistory, btnWishlist, btnSettings, btnLogout;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        EdgeToEdge.enable(this);
        setContentView(R.layout.activity_user);
        ViewCompat.setOnApplyWindowInsetsListener(findViewById(R.id.main), (v, insets) -> {
            Insets systemBars = insets.getInsets(WindowInsetsCompat.Type.systemBars());
            v.setPadding(systemBars.left, systemBars.top, systemBars.right, systemBars.bottom);
            return insets;
        });
        initializeViews();
        listeners();
        setupInfo();
    }

    private void initializeViews(){
        btnForum = findViewById(R.id.btnForum);
        btnCarrinho = findViewById(R.id.btnCarrinho);
        btnUser = findViewById(R.id.btnUser);
        btnHome = findViewById(R.id.btnHome);
        ivProfilePicture = findViewById(R.id.ivProfilePicture);
        tvUsername = findViewById(R.id.tvUsername);
        btnEdit = findViewById(R.id.btnEdit);
        btnInfo = findViewById(R.id.btnInfo);
        btnHistory = findViewById(R.id.btnHistory);
        btnWishlist = findViewById(R.id.btnWishlist);
        btnSettings = findViewById(R.id.btnSettings);
        btnLogout = findViewById(R.id.btnLogout);
    }

    private void setupInfo(){
        SharedPreferences prefs = getSharedPreferences("app_session", MODE_PRIVATE);

        String username = prefs.getString("username", null);
        tvUsername.setText(username);

        String image = prefs.getString("image", null);
        String userPfp = ApiConfig.BASE_URL + "/" + image;
        Glide.with(this)
                .load(userPfp)
                .diskCacheStrategy(DiskCacheStrategy.NONE)
                .skipMemoryCache(true)
                .into(ivProfilePicture);
    }

    private void listeners(){
        btnHome.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent intent = new Intent(UserActivity.this, MainActivity.class);
                startActivity(intent);
                finish();
            }
        });
        btnForum.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent intent = new Intent(UserActivity.this, ForumActivity.class);
                startActivity(intent);
                finish();
            }
        });

        btnCarrinho.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent intent = new Intent(UserActivity.this, CarrinhoActivity.class);
                startActivity(intent);
                finish();
            }
        });

        btnUser.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                setupInfo();
            }
        });

        btnEdit.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent intent = new Intent(UserActivity.this, EditUserActivity.class);
                startActivity(intent);
            }
        });

        btnInfo.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {

            }
        });

        btnHistory.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {

            }
        });

        btnWishlist.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {

            }
        });

        btnSettings.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {

            }
        });

        btnLogout.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                SharedPreferences prefs = getSharedPreferences("app_session", MODE_PRIVATE);
                prefs.edit().clear().apply();
                // Volta para o Login e limpa o back stack
                Intent intent = new Intent(UserActivity.this, EntranceActivity.class);
                intent.setFlags(Intent.FLAG_ACTIVITY_NEW_TASK | Intent.FLAG_ACTIVITY_CLEAR_TASK);
                startActivity(intent);
                finish();

            }
        });
    }
}