package com.example.imoral.adapters;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.recyclerview.widget.RecyclerView;

import com.example.imoral.R;
import com.example.imoral.models.Produto;

import java.util.ArrayList;
import java.util.List;

public class TamanhoAdapter extends RecyclerView.Adapter<TamanhoAdapter.TamanhoViewHolder> {

    public interface OnItemClickListener {
        void onItemClick(Produto produto);
    }

    private List<Produto> produtos = new ArrayList<>();
    private OnItemClickListener listener;

    private int layoutRes;

    private int selectedPosition;

    public TamanhoAdapter(int layoutRes) {
        this.layoutRes = layoutRes;
    }

    public void submitList(List<Produto> newprodutos) {
        if (newprodutos == null) return;
        this.produtos.clear();
        this.produtos.addAll(newprodutos);
        notifyDataSetChanged();
    }

    @NonNull
    @Override
    public TamanhoViewHolder onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
        View view = LayoutInflater.from(parent.getContext())
                .inflate(layoutRes, parent, false);
        return new TamanhoViewHolder(view);
    }

    @Override
    public void onBindViewHolder(@NonNull TamanhoViewHolder holder, int position) {
        Produto produto = this.produtos.get(position);

        holder.tvProdutoTamanho.setText(produto.getTamanho());

        if (position == selectedPosition) {
            holder.itemView.setBackgroundResource(R.drawable.greybutton_background);
        } else {
            holder.itemView.setBackgroundResource(R.drawable.blackbutton_background);
        }

        holder.itemView.setOnClickListener(v -> {
            selectedPosition = position;
            notifyDataSetChanged();
            if (listener != null) listener.onItemClick(produto);
        });
    }


    @Override
    public int getItemCount() {
        return this.produtos.size();
    }

    public static class TamanhoViewHolder extends RecyclerView.ViewHolder {
        TextView tvProdutoTamanho;

        public TamanhoViewHolder(@NonNull View itemView) {
            super(itemView);
            tvProdutoTamanho = itemView.findViewById(R.id.tvProdutoTamanho);
        }
    }

    public int getSelectedPosition(){
        return selectedPosition;
    }
    public void setSelectedPosition(int position){
        this.selectedPosition = position;

    }
}