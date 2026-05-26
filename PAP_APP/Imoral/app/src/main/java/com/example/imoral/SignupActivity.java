package com.example.imoral;

import android.content.Intent;
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

import com.example.imoral.api.ApiService;
import com.example.imoral.models.SignupResponse;

import network.RetrofitClient;
import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class SignupActivity extends AppCompatActivity {
    String jaTemContaText;

    TextView jaTemContaTextView;
    EditText editTextUser, editTextEmailAdress, editTextPassword, editTextComfirmPassword;
    Button buttonLogin;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        EdgeToEdge.enable(this);
        setContentView(R.layout.activity_signup);
        ViewCompat.setOnApplyWindowInsetsListener(findViewById(R.id.main), (v, insets) -> {
            Insets systemBars = insets.getInsets(WindowInsetsCompat.Type.systemBars());
            v.setPadding(systemBars.left, systemBars.top, systemBars.right, systemBars.bottom);
            return insets;
        });
        editTextUser = findViewById(R.id.editTextUser);
        editTextEmailAdress = findViewById(R.id.editTextEmailAdress);
        editTextPassword = findViewById(R.id.editTextPassword);
        editTextComfirmPassword = findViewById(R.id.editTextComfirmPassword);
        jaTemContaText = getString(R.string.ja_tem_conta_text);
        jaTemContaTextView = findViewById(R.id.jaTemContaTextView);
        buttonLogin = findViewById(R.id.buttonSignup);

        buttonLogin.setOnClickListener(v -> {
            String username = editTextUser.getText().toString().trim();
            String email = editTextEmailAdress.getText().toString().trim();
            String password = editTextPassword.getText().toString().trim();
            String passwordComfirm =  editTextComfirmPassword.getText().toString().trim();

            if (username.isEmpty() || email.isEmpty() || password.isEmpty() || passwordComfirm.isEmpty()) {
                Toast.makeText(SignupActivity.this, "Preencha todos os campos", Toast.LENGTH_SHORT).show();
                return;
            }

            if (!password.equals(passwordComfirm)){
                Toast.makeText(SignupActivity.this, "As senhas não coincidem", Toast.LENGTH_SHORT).show();
                return;
            }

            ApiService api = RetrofitClient.getInstance().create(ApiService.class);
            api.signup(username,email,password,passwordComfirm).enqueue(new Callback<SignupResponse>() {
                @Override
                public void onResponse(Call<SignupResponse> call, Response<SignupResponse> response) {
                    if(response.isSuccessful() && response.body() != null) {
                        SignupResponse signupResponse = response.body();
                        if (signupResponse.isSuccess()) {
                            Toast.makeText(SignupActivity.this, signupResponse.getMessage(), Toast.LENGTH_SHORT).show();
                            //Volta para a Mainactivity
                            Intent intent = new Intent(SignupActivity.this, MainActivity.class);
                            startActivity(intent);
                            finish();
                        } else {
                            Toast.makeText(SignupActivity.this, "Erro" + signupResponse.getMessage(), Toast.LENGTH_SHORT).show();
                         }
                        } else {
                            Toast.makeText(SignupActivity.this, "Erro na resposta do servidor", Toast.LENGTH_SHORT).show();
                        }
                    }
                @Override
                public void onFailure(Call<SignupResponse> call, Throwable t) {
                    Toast.makeText(SignupActivity.this, "Falha na conexão: " + t.getMessage(), Toast.LENGTH_SHORT).show();
                }
            });
        });

        updateTextViewSpannable();

    }

    public void updateTextViewSpannable() {
        jaTemContaTextView.setText(createSpannableClick());
        jaTemContaTextView.setMovementMethod(LinkMovementMethod.getInstance());
    }
    public SpannableString createSpannableClick(){
        SpannableString spannableString = createSpannableText();

        spannableString.setSpan(
                createClickableSpan(),
                jaTemContaText.indexOf("Entra"),
                20,
                Spanned.SPAN_EXCLUSIVE_EXCLUSIVE);

        return spannableString;
    }
    public SpannableString createSpannableText(){
        //torna a string spannable sendo possivel mudar o style e se é clicavel
        SpannableString spannableString = new SpannableString(jaTemContaText);

        return spannableString;
    }
    public ClickableSpan createClickableSpan(){
        //define qual parte do texto podera ser clicavel
        ClickableSpan clickableSpan = new ClickableSpan() {
            @Override
            public void onClick(@NonNull View widget) {
                //Toast.makeText(getApplicationContext(), "Clicado", Toast.LENGTH_SHORT).show();
                Intent intent = new Intent(SignupActivity.this, LoginActivity.class);
                startActivity(intent);
            }

            @Override
            public void updateDrawState(@NonNull TextPaint textPaint) {
                super.updateDrawState(textPaint);
                textPaint.setColor(Color.WHITE); // coloca cor azul
                textPaint.setUnderlineText(true); // Coloca o sublinhado
            }
        };

        return clickableSpan;
    }
}

