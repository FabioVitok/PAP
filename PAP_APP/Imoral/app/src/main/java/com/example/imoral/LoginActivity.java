package com.example.imoral;

import android.content.Intent;
import android.content.SharedPreferences;
import android.graphics.Color;
import android.os.Bundle;
import android.text.SpannableString;
import android.text.Spanned;
import android.text.TextPaint;
import android.text.method.LinkMovementMethod;
import android.text.style.ClickableSpan;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;

import androidx.activity.EdgeToEdge;
import androidx.annotation.NonNull;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.graphics.Insets;
import androidx.core.view.ViewCompat;
import androidx.core.view.WindowInsetsCompat;

import com.example.imoral.models.Login.LoginResponse;
import com.google.gson.Gson;

import java.io.IOException;

import okhttp3.Call;
import okhttp3.Callback;
import okhttp3.FormBody;
import okhttp3.OkHttpClient;
import okhttp3.Request;
import okhttp3.RequestBody;
import okhttp3.Response;
import utils.ApiConfig;

public class LoginActivity extends AppCompatActivity {

    String naoTemContaText;
    TextView naoTemContaTextView;
    EditText editTextEmail, editTextPassword;
    Button buttonLogin;
    private final OkHttpClient client = new OkHttpClient();
    private final Gson gson = new Gson();

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        EdgeToEdge.enable(this);
        setContentView(R.layout.activity_login);
        ViewCompat.setOnApplyWindowInsetsListener(findViewById(R.id.main), (v, insets) -> {
            Insets systemBars = insets.getInsets(WindowInsetsCompat.Type.systemBars());
            v.setPadding(systemBars.left, systemBars.top, systemBars.right, systemBars.bottom);
            return insets;
   });
        naoTemContaText = getString(R.string.nao_tem_conta_text);
        naoTemContaTextView = findViewById(R.id.naoTemContaTextView);
        buttonLogin = findViewById(R.id.buttonLogin);
        editTextEmail = findViewById(R.id.editTextEmail);
        editTextPassword = findViewById(R.id.editTextPassword);

        buttonLogin.setOnClickListener(v -> fazerLogin());
        updateTextViewSpannable();

    }

    public void updateTextViewSpannable() {
        naoTemContaTextView.setText(createSpannableClick());
        naoTemContaTextView.setMovementMethod(LinkMovementMethod.getInstance());
    }
    public SpannableString createSpannableClick(){
        SpannableString spannableString = createSpannableText();

        spannableString.setSpan(
                createClickableSpan(),
                naoTemContaText.indexOf("Regista-te"),
                26,
                Spanned.SPAN_EXCLUSIVE_EXCLUSIVE);

        return spannableString;
    }
    public SpannableString createSpannableText(){
        //torna a string spannable sendo possivel mudar o style e se é clicavel
        SpannableString spannableString = new SpannableString(naoTemContaText);

        return spannableString;
    }
    public ClickableSpan createClickableSpan(){
        //define qual parte do texto podera ser clicavel
        ClickableSpan clickableSpan = new ClickableSpan() {
            @Override
            public void onClick(@NonNull View widget) {
                //Toast.makeText(getApplicationContext(), "Clicado", Toast.LENGTH_SHORT).show();
                Intent intent = new Intent(LoginActivity.this, SignupActivity.class);
                startActivity(intent);
            }

            @Override
            public void updateDrawState(@NonNull TextPaint textPaint) {
                super.updateDrawState(textPaint);
                textPaint.setColor(Color.WHITE);
                textPaint.setUnderlineText(true); // Coloca o sublinhado
            }
        };

        return clickableSpan;
    }

    private void fazerLogin() {
        String email = editTextEmail.getText().toString().trim();
        String password = editTextPassword.getText().toString().trim();

        if (email.isEmpty()) {
            editTextEmail.setError("Email obrigatório");
            return;
        }

        if (password.isEmpty()) {
            editTextPassword.setError("Password obrigatória");
            return;
        }
        OkHttpClient client = new OkHttpClient();

        RequestBody formBody = new FormBody.Builder()
                .add("email", email)
                .add("password", password)
                .build();

        Request request = new Request.Builder()
                .url(ApiConfig.LOGIN_URL)
                .post(formBody)
                .build();

        client.newCall(request).enqueue(new Callback() {
            @Override
            public void onFailure(@NonNull Call call, @NonNull IOException e) {
                runOnUiThread(() -> Toast.makeText(LoginActivity.this, "Erro: " + e.getMessage(), Toast.LENGTH_SHORT).show());
            }

            @Override
            public void onResponse(@NonNull Call call, @NonNull Response response) throws IOException {
                String responseBody = response.body() != null ? response.body().string() : "";
                String statusCode = String.valueOf(response.code());
                try {
                    LoginResponse loginResponse = gson.fromJson(responseBody, LoginResponse.class);

                    runOnUiThread(() -> {
                        if (response.isSuccessful() && loginResponse != null && loginResponse.isSuccess()) {
                            SharedPreferences prefs = getSharedPreferences("app_session", MODE_PRIVATE);
                            SharedPreferences.Editor editor = prefs.edit();
                            editor.putString("jwt", loginResponse.getData().getJwt());
                            editor.putInt("user_id", loginResponse.getData().getUser().getId());
                            editor.putString("username", loginResponse.getData().getUser().getUsername());
                            editor.putString("image", loginResponse.getData().getUser().getImage());
                            editor.putString("email", loginResponse.getData().getUser().getEmail());
                            editor.putInt("carrinho_id", loginResponse.getData().getCarrinho().getId());
                            editor.putInt("wishlist_id", loginResponse.getData().getWishlist().getId());
                            editor.apply();

                            Toast.makeText(LoginActivity.this, "Login com sucesso", Toast.LENGTH_SHORT).show();
                            Intent intent = new Intent(LoginActivity.this, MainActivity.class);
                            startActivity(intent);
                            finish();
                        } else {
                            Toast.makeText(LoginActivity.this, loginResponse.getMessage(), Toast.LENGTH_SHORT).show();
                        }
                    });

                } catch (Exception e) {
                    runOnUiThread(() -> Toast.makeText(LoginActivity.this, "Erro ao processar resposta:\n" + responseBody, Toast.LENGTH_SHORT).show());
                }
            }
        });
    }
}