package com.example.imoral.adapters;

import android.content.Intent;
import android.os.Parcelable;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.recyclerview.widget.RecyclerView;

import com.bumptech.glide.Glide;
import com.example.imoral.PostActivity;
import com.example.imoral.ProdutoActivity;
import com.example.imoral.R;
import com.example.imoral.models.ImageHelper;
import com.example.imoral.models.Post;
import com.example.imoral.models.Utilizador;

import java.util.ArrayList;
import java.util.List;

import utils.ApiConfig;

public class PostAdapter extends RecyclerView.Adapter<PostAdapter.PostViewHolder> {


    private List<Post> Posts = new ArrayList<>();

    public void submitList(List<Post> newPosts) {
        if (newPosts == null) return;
        this.Posts.clear();
        this.Posts.addAll(newPosts);
        notifyDataSetChanged();
    }

    @NonNull
    @Override
    public PostAdapter.PostViewHolder onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
        View view = LayoutInflater.from(parent.getContext())
                .inflate(R.layout.item_post_text, parent, false);
        return new PostAdapter.PostViewHolder(view);
    }

    @Override
    public void onBindViewHolder(@NonNull PostAdapter.PostViewHolder holder, int position) {
        Post post = Posts.get(position);

        Log.d("IMG_URL", ApiConfig.BASE_URL + "/" + post.getImage());

        Glide.with(holder.itemView.getContext())
                .load(ApiConfig.BASE_URL + "/" + post.getImage())
                .into(holder.ivProfilePicture);

        holder.tvUsername.setText(post.getUsername());
        holder.tvData.setText(post.getDt_postagem());
        holder.tvTexto.setText(post.getTexto_post());
        holder.tvLikeCount.setText(String.valueOf(post.getLike_count()));
        holder.tvCommentCount.setText(String.valueOf(post.getComment_count()));

        holder.itemView.setOnClickListener(v -> {
            Intent i = new Intent(v.getContext(), PostActivity.class);
            i.putExtra("post", post);
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
        TextView tvCommentCount;

        public PostViewHolder(@NonNull View itemView) {
            super(itemView);
            ivProfilePicture  = itemView.findViewById(R.id.ivProfilePicture);
            tvUsername   = itemView.findViewById(R.id.tvUsername);
            tvData  = itemView.findViewById(R.id.tvData);
            tvTexto  = itemView.findViewById(R.id.tvTexto);
            tvLikeCount  = itemView.findViewById(R.id.tvLikeCount);
            tvCommentCount  = itemView.findViewById(R.id.tvCommentCount);
        }
    }
}
