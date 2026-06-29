package com.example.imoral.adapters;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.ImageButton;
import android.widget.ImageView;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.recyclerview.widget.RecyclerView;

import com.bumptech.glide.Glide;
import com.example.imoral.R;
import com.example.imoral.models.ProdutoCarrinho;

import java.util.ArrayList;
import java.util.List;

import utils.ApiConfig;

public class PedidoProdutoAdapter extends RecyclerView.Adapter<PedidoProdutoAdapter.PedidoProdutoViewHolder> {

    private List<ProdutoCarrinho> ProdutosCarrinho = new ArrayList<>();

    public void submitList(List<ProdutoCarrinho> newprodutos) {
        if (newprodutos == null) return;
        this.ProdutosCarrinho.clear();
        this.ProdutosCarrinho.addAll(newprodutos);
        notifyDataSetChanged();
    }

    @NonNull
    @Override
    public PedidoProdutoViewHolder onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
        View view = LayoutInflater.from(parent.getContext())
                .inflate(R.layout.item_produto_pedido, parent, false);
        return new PedidoProdutoViewHolder(view);
    }

    @Override
    public void onBindViewHolder(@NonNull PedidoProdutoViewHolder holder, int position) {
        ProdutoCarrinho produto = ProdutosCarrinho.get(position);


        Glide.with(holder.itemView.getContext())
                .load(ApiConfig.BASE_URL + "/" + produto.getImage())
                .into(holder.ivImage);

        holder.tvName.setText(produto.getNome());
        String precoIndividual = String.format("%.2f€", produto.getPrecoVenda());
        holder.tvProdutoPriceAlone.setText("Preço individual:     " + precoIndividual);
        String preco = String.format("%.2f€", produto.getPrecoVenda() * produto.getQuantidade());
        holder.tvPrice.setText("Preço:     " + preco);
        String quantidade = Integer.toString(produto.getQuantidade());
        holder.tvQuantidade.setText("Quantidade: " + quantidade);
        String Tamanho = ("Tamanho: " + produto.getTamanho());
        holder.tvProdutoTamanho.setText(Tamanho);

    }

    @Override
    public int getItemCount() {
        return ProdutosCarrinho != null ? ProdutosCarrinho.size() : 0;
    }

    // ViewHolder
    public static class PedidoProdutoViewHolder extends RecyclerView.ViewHolder {
        ImageView ivImage;
        TextView tvName, tvProdutoPriceAlone, tvPrice, tvQuantidade, tvProdutoTamanho;

        public PedidoProdutoViewHolder(@NonNull View itemView) {
            super(itemView);
            ivImage  = itemView.findViewById(R.id.ivProdutoImage);
            tvName   = itemView.findViewById(R.id.tvProdutoName);
            tvProdutoTamanho  = itemView.findViewById(R.id.tvProdutoTamanho);
            tvPrice  = itemView.findViewById(R.id.tvProdutoPrice);
            tvQuantidade  = itemView.findViewById(R.id.tvProdutoQuantidade);
            tvProdutoPriceAlone  = itemView.findViewById(R.id.tvProdutoPriceAlone);


        }


    }

}