package com.example.imoral.adapters;
import android.content.Intent;
import android.util.Log;
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
import com.example.imoral.models.ProdutoPai;

import java.util.ArrayList;
import java.util.List;

import utils.ApiConfig;

public class CarrinhoAdapter extends RecyclerView.Adapter<CarrinhoAdapter.ProdutoViewHolder> {
    public interface OnRemoverClickListener {
        void onRemover(ProdutoCarrinho produto);
    }

    public interface OnQuantidadeChangeListener {
        void onQuantidadeChange(ProdutoCarrinho produto, int quantidade);
    }

    public interface OnUiUpdateListener {
        void onUiUpdate();
    }

    private List<ProdutoCarrinho> ProdutosCarrinho = new ArrayList<>();
    private final OnRemoverClickListener removerListener;
    private final OnQuantidadeChangeListener quantidadeListener;

    private final OnUiUpdateListener uiUpdateListener;

    public CarrinhoAdapter(OnRemoverClickListener removerListener,
                           OnQuantidadeChangeListener quantidadeListener,
                           OnUiUpdateListener uiUpdateListener) {
        this.removerListener = removerListener;
        this.quantidadeListener = quantidadeListener;
        this.uiUpdateListener = uiUpdateListener;
    }

    public void submitList(List<ProdutoCarrinho> newprodutos) {
        if (newprodutos == null) return;
        this.ProdutosCarrinho.clear();
        this.ProdutosCarrinho.addAll(newprodutos);
        notifyDataSetChanged();
    }

    public void removeItem(ProdutoCarrinho produto) {
        int index = ProdutosCarrinho.indexOf(produto);
        if (index != -1) {
            ProdutosCarrinho.remove(index);
            notifyItemRemoved(index);
        }
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
       ProdutoCarrinho produto = ProdutosCarrinho.get(position);


        Glide.with(holder.itemView.getContext())
                .load(ApiConfig.BASE_URL + "/" + produto.getImage())
                .into(holder.ivImage);

        holder.tvName.setText(produto.getNome());
        String preco = String.format("%.2f€", produto.getPrecoVenda() * produto.getQuantidade());
        holder.tvPrice.setText(preco);
        String quantidade = Integer.toString(produto.getQuantidade());
        holder.tvQuantidade.setText(quantidade);
        String Tamanho = ("Tamanho: " + produto.getTamanho());
        holder.tvProdutoTamanho.setText(Tamanho);
        String priceAlone = (String.valueOf(produto.getPrecoVenda()));
        holder.tvProdutoPriceAlone.setText("Preço individual: " + priceAlone);

        /*holder.itemView.setOnClickListener(v -> {
            Intent i = new Intent(v.getContext(), ProdutosActivity.class);
            i.putExtra("prodNome", Produto.getNome());
            i.putExtra("prodImg",Produto.getImagemId());
            v.getContext().startActivity(i);
        });
        */

        holder.btnRemover.setOnClickListener(v -> {
            removerListener.onRemover(produto);
        });

        holder.btnMais.setOnClickListener(v -> {
            produto.setQuantidade(produto.getQuantidade() + 1);
            atualizarUiQuantidade(holder, produto);
            if (uiUpdateListener != null) uiUpdateListener.onUiUpdate();
            agendarPedido(holder, produto);
        });

        holder.btnMenos.setOnClickListener(v -> {
            if (produto.getQuantidade() > 1) {
                produto.setQuantidade(produto.getQuantidade() - 1);
                atualizarUiQuantidade(holder, produto);
                if (uiUpdateListener != null) uiUpdateListener.onUiUpdate();
                agendarPedido(holder, produto);
            }
        });

    }

    private void atualizarUiQuantidade(ProdutoViewHolder holder, ProdutoCarrinho produto) {
        holder.tvQuantidade.setText(String.valueOf(produto.getQuantidade()));
        holder.tvPrice.setText(String.format("%.2f€", produto.getPrecoVenda() * produto.getQuantidade()));
    }

    private void agendarPedido(ProdutoViewHolder holder, ProdutoCarrinho produto) {
        // cancela o timer anterior deste produto se existir
        if (holder.pendingUpdate != null) {
            holder.handler.removeCallbacks(holder.pendingUpdate);
        }
        holder.pendingUpdate = () -> quantidadeListener.onQuantidadeChange(produto, produto.getQuantidade());
        holder.handler.postDelayed(holder.pendingUpdate, 3000);
    }

    @Override
    public int getItemCount() {
        return ProdutosCarrinho != null ? ProdutosCarrinho.size() : 0;
    }

    // ViewHolder
    public static class ProdutoViewHolder extends RecyclerView.ViewHolder {
        ImageView ivImage;
        TextView tvName, tvPrice, tvQuantidade, tvProdutoTamanho, tvProdutoPriceAlone;
        Button btnMais;
        Button btnMenos;
        ImageButton btnRemover;

        final android.os.Handler handler = new android.os.Handler(android.os.Looper.getMainLooper());
        Runnable pendingUpdate;

        public ProdutoViewHolder(@NonNull View itemView) {
            super(itemView);
            ivImage  = itemView.findViewById(R.id.ivProdutoImage);
            tvName   = itemView.findViewById(R.id.tvProdutoName);
            tvPrice  = itemView.findViewById(R.id.tvProdutoPrice);
            tvQuantidade  = itemView.findViewById(R.id.tvQuantidade);
            tvProdutoTamanho  = itemView.findViewById(R.id.tvProdutoTamanho);
            tvProdutoPriceAlone  = itemView.findViewById(R.id.tvProdutoPriceAlone);
            btnMais     = itemView.findViewById(R.id.btnMais);
            btnMenos    = itemView.findViewById(R.id.btnMenos);
            btnRemover = itemView.findViewById(R.id.btnRemover);
        }

    }

    // se o item sair do ecrã com alterações de quantidade pendentes, dispara o pedido imediatamente
    @Override
    public void onViewRecycled(@NonNull ProdutoViewHolder holder) {
        super.onViewRecycled(holder);
        if (holder.pendingUpdate != null) {
            holder.handler.removeCallbacks(holder.pendingUpdate);
            holder.pendingUpdate.run();
            holder.pendingUpdate = null;
        }
    }


}