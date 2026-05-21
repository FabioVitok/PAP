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
import android.widget.TextView;

import androidx.activity.EdgeToEdge;
import androidx.annotation.NonNull;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.graphics.Insets;
import androidx.core.view.ViewCompat;
import androidx.core.view.WindowInsetsCompat;

public class SignupActivity extends AppCompatActivity {
    String jaTemContaText;

    TextView jaTemContaTextView;
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
        jaTemContaText = getString(R.string.ja_tem_conta_text);
        jaTemContaTextView = findViewById(R.id.jaTemContaTextView);

        updateTextViewSpannable();
        singupListener();

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

    public void singupListener() {
        Button buttonLogin = findViewById(R.id.buttonSignup);
        buttonLogin.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent intent = new Intent(SignupActivity.this, MainActivity.class);
                startActivity(intent);
            }
        });
    }
}

