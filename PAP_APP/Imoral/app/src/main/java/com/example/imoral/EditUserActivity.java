package com.example.imoral;

import android.content.Intent;
import android.content.SharedPreferences;
import android.net.Uri;
import android.os.Bundle;
import android.view.View;
import android.widget.EditText;
import android.widget.ImageButton;
import android.widget.ImageView;
import android.widget.Toast;

import androidx.activity.EdgeToEdge;
import androidx.activity.result.ActivityResultLauncher;
import androidx.activity.result.contract.ActivityResultContracts;
import androidx.appcompat.app.AppCompatActivity;
import androidx.constraintlayout.widget.ConstraintLayout;
import androidx.core.graphics.Insets;
import androidx.core.view.ViewCompat;
import androidx.core.view.WindowInsetsCompat;

import com.bumptech.glide.Glide;
import com.bumptech.glide.load.engine.DiskCacheStrategy;
import com.example.imoral.models.Forum.PostarResponse;
import com.google.gson.Gson;

import java.io.ByteArrayOutputStream;
import java.io.IOException;
import java.io.InputStream;

import okhttp3.Call;
import okhttp3.Callback;
import okhttp3.MediaType;
import okhttp3.MultipartBody;
import okhttp3.OkHttpClient;
import okhttp3.Request;
import okhttp3.RequestBody;
import okhttp3.Response;
import utils.ApiConfig;

public class EditUserActivity extends AppCompatActivity {

    private ImageButton btnBack;
    private ConstraintLayout btnProfilePicture, btnBanner, btnSave;
    private EditText etUsername;
    private ImageView ivBanner, ivProfilePicture;
    private final OkHttpClient client = new OkHttpClient();
    private final Gson gson = new Gson();
    private Uri selectedProfileUri = null;


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        EdgeToEdge.enable(this);
        setContentView(R.layout.activity_edit_user);
        ViewCompat.setOnApplyWindowInsetsListener(findViewById(R.id.main), (v, insets) -> {
            Insets systemBars = insets.getInsets(WindowInsetsCompat.Type.systemBars());
            v.setPadding(systemBars.left, systemBars.top, systemBars.right, systemBars.bottom);
            return insets;
        });

        initializeViews();
        setUserInfo();
        listeners();
    }

    private void initializeViews(){
        btnBack = findViewById(R.id.btnBack);
        btnProfilePicture = findViewById(R.id.btnProfilePicture);
        btnBanner = findViewById(R.id.btnBanner);
        btnSave = findViewById(R.id.btnSave);
        etUsername = findViewById(R.id.etUsername);
        ivBanner = findViewById(R.id.ivBanner);
        ivProfilePicture = findViewById(R.id.ivProfilePicture);
    }

    private void listeners() {

        btnBack.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent intent = new Intent(EditUserActivity.this, UserActivity.class);
                startActivity(intent);
                finish();
            }
        });

        btnProfilePicture.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                pickImage.launch("image/*");
            }
        });

        btnBanner.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                pickImageBanner.launch("image/*");
            }
        });

        btnSave.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                updateProfile();
            }
        });
    }

    private void setUserInfo() {
        SharedPreferences prefs = getSharedPreferences("app_session", MODE_PRIVATE);

        String username = prefs.getString("username", null);
        etUsername.setText(username);

        String image = prefs.getString("image", null);
        if(image == null){
            String userPfp = ApiConfig.BASE_URL + "/assets/images/users/user_icon.png";
            Glide.with(this)
                    .load(userPfp)
                    .diskCacheStrategy(DiskCacheStrategy.NONE)
                    .skipMemoryCache(true)
                    .into(ivProfilePicture);

        } else {
            String userPfp = ApiConfig.BASE_URL + "/" + image;
            Glide.with(this)
                    .load(userPfp)
                    .diskCacheStrategy(DiskCacheStrategy.NONE)
                    .skipMemoryCache(true)
                    .into(ivProfilePicture);
        }
    }

    private final ActivityResultLauncher<String> pickImage =
            registerForActivityResult(new ActivityResultContracts.GetContent(), uri -> {
                if (uri != null) {
                    selectedProfileUri = uri;
                    ivProfilePicture.setImageURI(uri);
                }
            });

    private final ActivityResultLauncher<String> pickImageBanner =
            registerForActivityResult(
                    new ActivityResultContracts.GetContent(),
                    uri -> {
                        if (uri != null) {
                            ivBanner.setImageURI(uri);
                        }
                    }
            );

    private byte[] uriToBytes(Uri uri) throws IOException {
        InputStream inputStream = getContentResolver().openInputStream(uri);
        ByteArrayOutputStream byteBuffer = new ByteArrayOutputStream();
        byte[] buffer = new byte[1024];
        int len;
        while ((len = inputStream.read(buffer)) != -1) {
            byteBuffer.write(buffer, 0, len);
        }
        return byteBuffer.toByteArray();
    }


    private void updateProfile() {
        SharedPreferences prefs = getSharedPreferences("app_session", MODE_PRIVATE);
        String jwt = prefs.getString("jwt", null);
        int userId = prefs.getInt("user_id", 0);

        String username = etUsername.getText().toString().trim();

        MultipartBody.Builder builder = new MultipartBody.Builder()
                .setType(MultipartBody.FORM)
                .addFormDataPart("username", username);

        try {
            if (selectedProfileUri != null) {
                byte[] profileBytes = uriToBytes(selectedProfileUri);
                builder.addFormDataPart("image", "profile.jpg",
                        RequestBody.create(profileBytes, MediaType.parse("image/jpeg")));
            }
        } catch (IOException e) {
            e.printStackTrace();
            return;
        }

        Request request = new Request.Builder()
                .url(ApiConfig.PROFILE_URL + userId)
                .post(builder.build())
                .addHeader("Authorization", "Bearer " + jwt)
                .build();

        client.newCall(request).enqueue(new Callback() {
            @Override
            public void onFailure(Call call, IOException e) {
                runOnUiThread(() -> Toast.makeText(EditUserActivity.this, "Erro: " + e.getMessage(), Toast.LENGTH_SHORT).show());
            }

            @Override
            public void onResponse(Call call, Response response) throws IOException {
                String responseBody = response.body() != null ? response.body().string() : "";
                try {
                    android.util.Log.d("UPDATE_PROFILE", "Status: " + response.code() + " | Body: " + responseBody);
                    PostarResponse resp = gson.fromJson(responseBody, PostarResponse.class);

                    if (resp != null && resp.isSuccess()) {
                        runOnUiThread(() -> Toast.makeText(EditUserActivity.this, "Post Postado!", Toast.LENGTH_SHORT).show());
                        SharedPreferences.Editor editor = prefs.edit();
                        String caminhoImagem = ("assets/images/users/" + userId + ".jpg");
                        editor.putString("username", username);
                        editor.putString("image", caminhoImagem);
                        editor.apply();
                    } else {
                        runOnUiThread(() -> Toast.makeText(EditUserActivity.this, "Erro ao postar", Toast.LENGTH_SHORT).show());
                    }
                } catch (Exception e) {
                    runOnUiThread(() -> Toast.makeText(EditUserActivity.this, "Erro ao converter JSON:\n" + e.getMessage(), Toast.LENGTH_SHORT).show());
                }
            }
        });
    }


}



