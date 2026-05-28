package com.example.imoral.adapters;
import android.content.Intent;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.TextView;
import androidx.annotation.NonNull;
import androidx.recyclerview.widget.RecyclerView;

import com.example.imoral.ProdutosActivity;
import com.example.imoral.R;
import com.example.imoral.models.ImageHelper;
import com.example.imoral.models.ProdutoPai;

import java.util.ArrayList;
import java.util.List;

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

    /*public ProdutoAdapter(List<ProdutoPai> Produtos, OnItemClickListener listener) {
        this.Produtos = Produtos;
        this.listener = listener;
    } */

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
        int image = ImageHelper.getDrawableResourceId(holder.itemView.getContext(), ProdutoPai.getImage());

        holder.ivImage.setImageResource(image);
        holder.tvName.setText(ProdutoPai.getNome());
        String preco = Double.toString(ProdutoPai.getPreco_venda());
        holder.tvPrice.setText(preco);

        holder.itemView.setOnClickListener(v -> {
            Intent i = new Intent(v.getContext(), ProdutosActivity.class);
            i.putExtra("prodNome", ProdutoPai.getNome());
            i.putExtra("prodImg",image);
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