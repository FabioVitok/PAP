package com.example.imoral;

import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ImageButton;
import android.widget.ImageView;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.fragment.app.DialogFragment;
import androidx.recyclerview.widget.RecyclerView;

import com.bumptech.glide.Glide;
import com.bumptech.glide.load.engine.DiskCacheStrategy;
import com.example.imoral.adapters.TamanhoAdapter;
import com.example.imoral.models.Produto;
import com.example.imoral.models.ProdutoPai;
import com.google.android.material.bottomsheet.BottomSheetDialogFragment;

import java.util.ArrayList;
import java.util.List;

import utils.ApiConfig;

public class PostFragment extends BottomSheetDialogFragment {
    public interface OnPostListener {

        // metodo chamado quando o utilizador Posta o post.
        void onPostRealizado(String texto);

    }

    private PostFragment.OnPostListener postListener;

    TextView tvUsername;
    EditText etTextoPost;
    ImageButton btnPostar;
    ImageButton btnFechar;
    ImageView ivProfilePicture;
    String username;
    String image;

    public void setOnPostListener(PostFragment.OnPostListener listener) {
        this.postListener = listener;
    }

    public static PostFragment newInstance(String username, String image){
        // Cria uma nova instância do BottomSheet
        PostFragment fragment = new PostFragment();

        // Cria um Bundle
        Bundle bundle = new Bundle();

        // Coloca os dados no Bundle
        bundle.putString("username", username);
        bundle.putString("image", image);


        // Anexa o Bundle ao Fragment
        fragment.setArguments(bundle);

        return fragment;
    }

    @Nullable
    @Override
    public View onCreateView(@NonNull LayoutInflater inflater,
                             @Nullable ViewGroup container,
                             @Nullable Bundle savedInstanceState) {
        // Associa a classe ao respetivo layout
        View view = inflater.inflate(R.layout.fragment_post, container, false);

        if (getArguments() != null) {

            //Atribui os dados do budnle a variaveis locais
            username = getArguments().getString("username");
            image = getArguments().getString("image");

        }

        // Associar as variaveis locais aos respetivos elementos do xml
        tvUsername = view.findViewById(R.id.tvUsername);
        etTextoPost = view.findViewById(R.id.etTextoPost);
        btnPostar = view.findViewById(R.id.btnPostar);
        ivProfilePicture = view.findViewById(R.id.ivProfilePicture);
        //btnFechar = view.findViewById(R.id.btnPost);


        tvUsername.setText(username);
        String userPfp = ApiConfig.BASE_URL + "/" + image;
        Glide.with(this)
                .load(userPfp)
                .diskCacheStrategy(DiskCacheStrategy.NONE)
                .skipMemoryCache(true)
                .into(ivProfilePicture);


        // setOnclickListener para o botão Postar
        btnPostar.setOnClickListener(v -> {
            // Notifica o listener sobre a compra realizada
            if (postListener != null) {
                String textoPost= etTextoPost.getText().toString();
                postListener.onPostRealizado(textoPost);
            }
            dismiss();   // Fecha o BottomSheet
        });


        /* setOnclickListener para o botão cancelar
        btnFechar.setOnClickListener(v -> {
            dismiss(); // Fecha o BottomSheet
        });
*/
        return view;
    }

    @Override
    public void onStart() {
        super.onStart();
        if (getDialog() != null && getDialog().getWindow() != null) {
            getDialog().getWindow().setLayout(
                    ViewGroup.LayoutParams.MATCH_PARENT,
                    ViewGroup.LayoutParams.WRAP_CONTENT
            );
        }
    }

}
