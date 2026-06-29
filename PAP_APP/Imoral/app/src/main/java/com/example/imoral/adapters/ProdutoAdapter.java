package com.example.imoral.adapters;
import android.content.Intent;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.TextView;
import androidx.annotation.NonNull;
import androidx.recyclerview.widget.RecyclerView;

import com.bumptech.glide.Glide;
import com.example.imoral.ProdutoActivity;
import com.example.imoral.R;
import com.example.imoral.models.ImageHelper;
import com.example.imoral.models.ProdutoPai;

import java.util.ArrayList;
import java.util.List;

import utils.ApiConfig;

public class ProdutoAdapter extends RecyclerView.Adapter<ProdutoAdapter.ProdutoViewHolder> {

    /* public interface OnItemClickListener {
        void onItemClick(Produto Produto);
    } */

    private List<ProdutoPai> Produtos = new ArrayList<>();
    //private OnItemClickListener listener;

    public void submitList(List<ProdutoPai> produtos) {
        if (produtos == null) return;
        Produtos.clear();
        Produtos.addAll(produtos);
        notifyDataSetChanged();
    }


    @NonNull
    @Override
    public ProdutoViewHolder onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
        View view = LayoutInflater.from(parent.getContext())
                .inflate(R.layout.item_produto, parent, false);
        return new ProdutoViewHolder(view);
    }

    @Override
    public void onBindViewHolder(@NonNull ProdutoViewHolder holder, int position) {
        ProdutoPai ProdutoPai = Produtos.get(position);

        Log.d("IMG_URL", ApiConfig.BASE_URL + "/" +ProdutoPai.getImage());

        Glide.with(holder.itemView.getContext())
                .load(ApiConfig.BASE_URL + "/" +ProdutoPai.getImage())
                .into(holder.ivImage);


        //holder.ivImage.setImageResource(image);
        holder.tvName.setText(ProdutoPai.getNome());
        String preco = String.format("%.2f€", ProdutoPai.getPreco_venda());
        holder.tvPrice.setText(preco);

        holder.itemView.setOnClickListener(v -> {
            Intent i = new Intent(v.getContext(), ProdutoActivity.class);
            i.putExtra("ProdutoPai", ProdutoPai);
            v.getContext().startActivity(i);
        });
    }

    @Override
    public int getItemCount() {
        return Produtos.size();
    }

    // ViewHolder
    public static class ProdutoViewHolder extends RecyclerView.ViewHolder {
        ImageView ivImage;
        TextView tvName;
        TextView tvPrice;

        public ProdutoViewHolder(@NonNull View itemView) {
            super(itemView);
            ivImage  = itemView.findViewById(R.id.ivProdutoImage);
            tvName   = itemView.findViewById(R.id.tvProdutoName);
            tvPrice  = itemView.findViewById(R.id.tvProdutoPrice);
        }
    }
}