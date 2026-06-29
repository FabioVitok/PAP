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
import com.bumptech.glide.load.engine.DiskCacheStrategy;
import com.example.imoral.PedidoActivity;
import com.example.imoral.PerfilActivity;
import com.example.imoral.PostActivity;
import com.example.imoral.R;
import com.example.imoral.models.Pedido;
import com.example.imoral.models.Post;

import java.util.ArrayList;
import java.util.List;

import utils.ApiConfig;

public class PedidoAdapter extends RecyclerView.Adapter<PedidoAdapter.PedidoViewHolder> {

    private List<Pedido> Pedidos = new ArrayList<>();

    public void submitList(List<Pedido> newPedidos) {
        if (newPedidos == null) return;
        this.Pedidos.clear();
        this.Pedidos.addAll(newPedidos);
        notifyDataSetChanged();
    }


    @NonNull
    @Override
    public PedidoAdapter.PedidoViewHolder onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
        View view = LayoutInflater.from(parent.getContext())
                .inflate(R.layout.item_pedido, parent, false);
        return new PedidoAdapter.PedidoViewHolder(view);
    }

    @Override
    public void onBindViewHolder(@NonNull PedidoAdapter.PedidoViewHolder holder, int position) {
        Pedido pedido = Pedidos.get(position);

        holder.tvMorada.setText(pedido.getMorada_entrega());
        holder.tvValor.setText(pedido.getValor() + "€");
        holder.tvData.setText(pedido.getDt_compra());
        holder.tvIdPedido.setText(String.valueOf(pedido.getPedido_id()));

        holder.itemView.setOnClickListener(v -> {
            Intent i = new Intent(v.getContext(), PedidoActivity.class);
            i.putExtra("pedido", pedido);
            v.getContext().startActivity(i);
        });

    }


    @Override
    public int getItemCount() {
        return Pedidos.size();
    }

    // ViewHolder
    public static class PedidoViewHolder extends RecyclerView.ViewHolder {
        TextView tvMorada, tvValor, tvData, tvIdPedido;

        public PedidoViewHolder(@NonNull View itemView) {
            super(itemView);
            tvMorada  = itemView.findViewById(R.id.tvMorada);
            tvValor   = itemView.findViewById(R.id.tvValor);
            tvData  = itemView.findViewById(R.id.tvData);
            tvIdPedido  = itemView.findViewById(R.id.tvIdPedido);
        }
    }
}
