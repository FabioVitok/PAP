package com.example.imoral;
import android.content.Intent;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.TextView;
import androidx.annotation.NonNull;
import androidx.recyclerview.widget.RecyclerView;

import com.example.imoral.models.Produto;

import java.util.List;

public class CarrinhoAdapter extends RecyclerView.Adapter<CarrinhoAdapter.ProdutoViewHolder> {

    public interface OnItemClickListener {
        void onItemClick(Produto Produto);
    }

    private List<Produto> Produtos;
    private OnItemClickListener listener;

    public CarrinhoAdapter(List<Produto> Produtos, OnItemClickListener listener) {
        this.Produtos = Produtos;
        this.listener = listener;
    }

    @NonNull
    @Override
    public ProdutoViewHolder onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
        View view = LayoutInflater.from(parent.getContext())
                .inflate(R.layout.item_produto_carrinho, parent, false);
        return new ProdutoViewHolder(view);
    }

    @Override
    public void onBindViewHolder(@NonNull ProdutoViewHolder holder, int position) {
        Produto Produto = Produtos.get(position);

        holder.ivImage.setImageResource(Produto.getImagemId());
        holder.tvName.setText(Produto.getNome());
        String preco = Double.toString(Produto.getPrecoVenda());
        holder.tvPrice.setText(preco);

        holder.itemView.setOnClickListener(v -> {
            Intent i = new Intent(v.getContext(), ProdutosActivity.class);
            i.putExtra("prodNome", Produto.getNome());
            i.putExtra("prodImg",Produto.getImagemId());
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