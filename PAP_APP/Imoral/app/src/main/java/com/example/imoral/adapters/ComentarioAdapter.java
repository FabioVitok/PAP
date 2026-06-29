package com.example.imoral.adapters;

import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageButton;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import com.bumptech.glide.Glide;
import com.bumptech.glide.load.engine.DiskCacheStrategy;
import com.example.imoral.R;
import com.example.imoral.models.Comentario;
import com.example.imoral.models.ProdutoCarrinho;
import com.google.android.material.imageview.ShapeableImageView;

import java.util.ArrayList;
import java.util.List;

import utils.ApiConfig;

public class ComentarioAdapter extends RecyclerView.Adapter<ComentarioAdapter.ComentarioViewHolder> {

    public interface OnRespostasClickListener {
        void onRespostas(Comentario comentario);
    }

    public interface OnResponderClickListener {
        void onResponder(int idComentarioPai);
    }

    private final OnRespostasClickListener respostasListener;
    private final OnResponderClickListener responderListener;
    private List<Comentario> comentarios = new ArrayList<>();
    private List<Comentario> respostas = new ArrayList<>();
    private boolean mostrarRespostas = false;
    private Comentario comentario;

    public ComentarioAdapter(OnRespostasClickListener respostasListener,
                             OnResponderClickListener responderListener) {
        this.respostasListener = respostasListener;
        this.responderListener = responderListener;
    }


    public void submitList(List<Comentario> novosComentarios) {
        if (novosComentarios == null) return;
        this.comentarios.clear();
        this.comentarios.addAll(novosComentarios);
        notifyDataSetChanged();
    }

    public void submitRespostasList(int comentarioId, List<Comentario> novasRespostas) {
        for (int i = 0; i < comentarios.size(); i++) {
            if (comentarios.get(i).getId() == comentarioId) {
                comentarios.get(i).setRespostas(novasRespostas);
                notifyItemChanged(i);
                break;
            }
        }
    }


    @NonNull
    @Override
    public ComentarioViewHolder onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
        View view = LayoutInflater.from(parent.getContext())
                .inflate(R.layout.item_comentario, parent, false);
        return new ComentarioViewHolder(view);
    }

    @Override
    public void onBindViewHolder(@NonNull ComentarioViewHolder holder, int position) {
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
        holder.tvRespostasCount.setText(String.valueOf(comentario.getComment_count()));
        holder.btnLike.setOnClickListener(v -> {
            // handle like click
        });

        holder.btnRespostas.setOnClickListener(v -> {
            respostasListener.onRespostas(comentario);
            comentario.setMostrarRespostas(!comentario.isMostrarRespostas());
            notifyItemChanged(holder.getAdapterPosition());
        });

        holder.btnResponder.setOnClickListener(v -> {
            int idComentarioPai = comentario.getId();
            responderListener.onResponder(idComentarioPai);
        });


        holder.rvRespostas.setVisibility(comentario.isMostrarRespostas() ? View.VISIBLE : View.GONE);
        holder.rvRespostas.setLayoutManager(new LinearLayoutManager(holder.itemView.getContext()));
        holder.rvRespostas.setAdapter(new RespostaAdapter(comentario.getRespostas()));



    }

    @Override
    public int getItemCount() {
        return comentarios.size();
    }

    public static class ComentarioViewHolder extends RecyclerView.ViewHolder {
        ShapeableImageView ivProfilePicture;
        TextView tvUsername, tvData, tvTexto, tvLikeCount, tvRespostasCount, btnResponder;
        ;
        ImageButton btnLike, btnRespostas;
        RecyclerView rvRespostas;

        public ComentarioViewHolder(@NonNull View itemView) {
            super(itemView);
            ivProfilePicture = itemView.findViewById(R.id.ivProfilePicture);
            tvUsername = itemView.findViewById(R.id.tvUsername);
            tvData = itemView.findViewById(R.id.tvData);
            tvTexto = itemView.findViewById(R.id.tvTexto);
            tvLikeCount = itemView.findViewById(R.id.textView);
            tvRespostasCount = itemView.findViewById(R.id.tvRespostasCount);
            btnLike = itemView.findViewById(R.id.imageButton2);
            btnRespostas = itemView.findViewById(R.id.btnRespostas);
            btnResponder = itemView.findViewById(R.id.btnResponder);
            rvRespostas = itemView.findViewById(R.id.rvRespostas);

        }
    }
}