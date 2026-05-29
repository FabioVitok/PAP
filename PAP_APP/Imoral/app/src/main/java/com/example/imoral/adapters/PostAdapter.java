package com.example.imoral.adapters;

import android.content.Intent;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.recyclerview.widget.RecyclerView;

import com.example.imoral.PostActivity;
import com.example.imoral.ProdutosActivity;
import com.example.imoral.R;
import com.example.imoral.models.ImageHelper;
import com.example.imoral.models.Post;
import com.example.imoral.models.Utilizador;

import java.util.ArrayList;
import java.util.List;

public class PostAdapter extends RecyclerView.Adapter<PostAdapter.PostViewHolder> {

    /* public interface OnItemClickListener {
        void onItemClick(Produto Produto);
    } */

    private List<Post> Posts = new ArrayList<>();
    //private OnItemClickListener listener;

    public void submitList(List<Post> newPosts) {
        if (newPosts == null) return;
        this.Posts.clear();
        this.Posts.addAll(newPosts);
        notifyDataSetChanged();
    }

    /*public ProdutoAdapter(List<ProdutoPai> Produtos, OnItemClickListener listener) {
        this.Produtos = Produtos;
        this.listener = listener;
    } */

    @NonNull
    @Override
    public PostAdapter.PostViewHolder onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
        View view = LayoutInflater.from(parent.getContext())
                .inflate(R.layout.item_post_text, parent, false);
        return new PostAdapter.PostViewHolder(view);
    }

    @Override
    public void onBindViewHolder(@NonNull PostAdapter.PostViewHolder holder, int position) {
        Post Post =  Posts.get(position);
        int image = ImageHelper.getDrawableResourceId(holder.itemView.getContext(), Post.getUser().getImage());

        holder.ivProfilePicture.setImageResource(image);
        holder.tvUsername.setText(Post.getUser().getUsername());
        holder.tvData.setText(Post.getDtPostagem());
        holder.tvTexto.setText(Post.getTextoPost());
        holder.tvLikeCount.setText(String.valueOf(Post.getLikeCount()));

        holder.itemView.setOnClickListener(v -> {
            Intent i = new Intent(v.getContext(), PostActivity.class);
            i.putExtra("posttexto", Post.getTextoPost());
            i.putExtra("prodImg",image);
            v.getContext().startActivity(i);
        });
    }

    @Override
    public int getItemCount() {
        return Posts.size();
    }

    // ViewHolder
    public static class PostViewHolder extends RecyclerView.ViewHolder {
        ImageView ivProfilePicture;
        TextView tvUsername;
        TextView tvData;
        TextView tvTexto;
        TextView tvLikeCount;

        public PostViewHolder(@NonNull View itemView) {
            super(itemView);
            ivProfilePicture  = itemView.findViewById(R.id.ivProfilePicture);
            tvUsername   = itemView.findViewById(R.id.tvUsername);
            tvData  = itemView.findViewById(R.id.tvData);
            tvTexto  = itemView.findViewById(R.id.tvTexto);
            tvLikeCount  = itemView.findViewById(R.id.tvLikeCount);
        }
    }
}
