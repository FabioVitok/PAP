package com.example.imoral.adapters;

import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageButton;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.recyclerview.widget.RecyclerView;

import com.bumptech.glide.Glide;
import com.bumptech.glide.load.engine.DiskCacheStrategy;
import com.example.imoral.R;
import com.example.imoral.models.Comentario;
import com.google.android.material.imageview.ShapeableImageView;

import java.util.ArrayList;
import java.util.List;

import utils.ApiConfig;

public class RespostaAdapter extends RecyclerView.Adapter<RespostaAdapter.RespostaViewHolder>{
    private List<Comentario> comentarios = new ArrayList<>();

    public RespostaAdapter(List<Comentario> respostas) {
        if (respostas != null) {
            this.comentarios.addAll(respostas);
        }
    }

    public void submitList(List<Comentario> novosComentarios) {
        if (novosComentarios == null) return;
        this.comentarios.clear();
        this.comentarios.addAll(novosComentarios);
        notifyDataSetChanged();
    }

    @NonNull
    @Override
    public RespostaAdapter.RespostaViewHolder onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
        View view = LayoutInflater.from(parent.getContext())
                .inflate(R.layout.item_resposta, parent, false);
        return new RespostaAdapter.RespostaViewHolder(view);
    }

    @Override
    public void onBindViewHolder(@NonNull RespostaAdapter.RespostaViewHolder holder, int position) {
        Comentario comentario = comentarios.get(position);

        Log.d("IMG_URL", ApiConfig.BASE_URL + "/" + comentario.getImage());

        Glide.with(holder.itemView.getContext())
                .load(ApiConfig.BASE_URL + "/" + comentario.getImage())
                .diskCacheStrategy(DiskCacheStrategy.NONE)
                .skipMemoryCache(true)
                .into(holder.ivProfilePicture);

        holder.tvUsername.setText(comentario.getUsername());
        holder.tvData.setText(comentario.getDt_comentario());
        holder.tvTexto.setText(comentario.getTexto_comentario());
        holder.tvLikeCount.setText(String.valueOf(comentario.getLike_count()));
        holder.btnLike.setOnClickListener(v -> {

        });
    }

    @Override
    public int getItemCount() {
        return comentarios.size();
    }

    public static class RespostaViewHolder extends RecyclerView.ViewHolder {
        ShapeableImageView ivProfilePicture;
        TextView tvUsername, tvData, tvTexto, tvLikeCount;
        ImageButton btnLike;

        public RespostaViewHolder(@NonNull View itemView) {
            super(itemView);
            ivProfilePicture = itemView.findViewById(R.id.ivProfilePicture);
            tvUsername       = itemView.findViewById(R.id.tvUsername);
            tvData           = itemView.findViewById(R.id.tvData);
            tvTexto          = itemView.findViewById(R.id.tvTexto);
            tvLikeCount      = itemView.findViewById(R.id.textView);
            btnLike          = itemView.findViewById(R.id.imageButton2);
        }
    }

}


