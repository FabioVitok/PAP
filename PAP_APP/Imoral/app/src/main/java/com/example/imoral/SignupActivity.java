package com.example.imoral;

import android.content.Intent;
import android.graphics.Color;
import android.os.Bundle;
import android.text.SpannableString;
import android.text.Spanned;
import android.text.TextPaint;
import android.text.method.LinkMovementMethod;
import android.text.style.ClickableSpan;
import android.util.Log;
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

import com.example.imoral.models.Signup.SignupResponse;
import com.google.gson.Gson;

import java.io.IOException;

import okhttp3.Call;
import okhttp3.Callback;
import okhttp3.MediaType;
import okhttp3.OkHttpClient;
import okhttp3.Request;
import okhttp3.RequestBody;
import okhttp3.Response;
import utils.ApiConfig;


public class SignupActivity extends AppCompatActivity {
    String jaTemContaText;
    private final OkHttpClient client = new OkHttpClient();
    private final Gson gson = new Gson();
    TextView jaTemContaTextView;
    EditText editTextUser, editTextEmailAdress, editTextPassword, editTextComfirmPassword;
    Button buttonSignup;

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
        buttonSignup = findViewById(R.id.buttonSignup);

        buttonSignup.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                String username = editTextUser.getText().toString().trim();
                String email = editTextEmailAdress.getText().toString().trim();
                String password = editTextPassword.getText().toString().trim();
                String passwordComfirm = editTextComfirmPassword.getText().toString().trim();

                // toasts de erros
                if (username.isEmpty() || email.isEmpty() || password.isEmpty() || passwordComfirm.isEmpty()) {
                    Toast.makeText(SignupActivity.this, "Preencha todos os campos", Toast.LENGTH_SHORT).show();
                    return;
                } else if (!password.equals(passwordComfirm)) {
                    Toast.makeText(SignupActivity.this, "As passwords não coincidem", Toast.LENGTH_SHORT).show();
                    return;
                }

                //string que o de json que vai ser enviada para a api, tem de ser igual ao que a api espera
                String json = "{\"email\":\"" + email + "\",\"username\":\"" + username +  "\",\"password\":\"" + password + "\",\"confirm_password\":\"" + passwordComfirm + "\"}";

                // formato para enviar o json para a api
                RequestBody body = RequestBody.create(json, MediaType.parse("application/json"));

                // conexao com a api
                Request request = new Request.Builder()
                        .url(ApiConfig.SIGNUP_URL)
                        .post(body)
                        .build();

                // resposta da api
                client.newCall(request).enqueue(new Callback() {

                    // resposta de erro da api
                    @Override
                    public void onFailure(Call call, IOException e) {
                        runOnUiThread(() -> Toast.makeText(SignupActivity.this, "Erro: " + e.getMessage(), Toast.LENGTH_SHORT).show());
                    }

                    // resposta de sucesso da api
                    @Override
                    public void onResponse(Call call, Response response) throws IOException {
                        String responseBody = response.body() != null ? response.body().string() : "";

                        Log.d("SIGNUP", responseBody);
                        try {
                            SignupResponse signupResponse = gson.fromJson(responseBody, SignupResponse.class);

                            if (signupResponse != null && signupResponse.isSuccess()) {
                                runOnUiThread(() -> {
                                    Toast.makeText(SignupActivity.this, signupResponse.getMessage(), Toast.LENGTH_SHORT).show();
                                    Intent intent = new Intent(SignupActivity.this, LoginActivity.class);
                                    startActivity(intent);
                                });
                            } else {
                                runOnUiThread(() -> Toast.makeText(SignupActivity.this, signupResponse.getMessage(), Toast.LENGTH_SHORT).show());
                            }

                        } catch (Exception e) {
                            runOnUiThread(() -> Toast.makeText(SignupActivity.this, "Erro ao converter JSON:\n" + e.getMessage(), Toast.LENGTH_SHORT).show());
                        }
                    }
                });
            }
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

