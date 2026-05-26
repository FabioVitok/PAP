package adapters;
import android.content.Intent;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.ImageView;
import android.widget.TextView;
import androidx.annotation.NonNull;
import androidx.recyclerview.widget.RecyclerView;

import com.example.imoral.ProdutosActivity;
import com.example.imoral.R;
import com.example.imoral.models.Carrinho;
import com.example.imoral.models.Produto;
import com.example.imoral.models.ProdutoCarrinho;

import java.util.List;

public class CarrinhoAdapter extends RecyclerView.Adapter<CarrinhoAdapter.ProdutoViewHolder> {

    public interface OnItemClickListener {
        void onItemClick(Produto Produto);
    }

    private List<ProdutoCarrinho> ProdutosCarrinho;
    private OnItemClickListener listener;

    private Carrinho carrinho;

    public CarrinhoAdapter(Carrinho carrinho, OnItemClickListener listener) {
        this.carrinho = carrinho;
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
        Produto Produto = this.carrinho.getProdutosCarrinho().get(position).getProduto();
        ProdutoCarrinho ProdutoCarrinho = this.carrinho.getProdutosCarrinho().get(position);

        holder.ivImage.setImageResource(Produto.getImagemId());
        holder.tvName.setText(Produto.getNome());
        String preco = Double.toString(Produto.getPrecoVenda());
        holder.tvPrice.setText(preco);
        String quantidade = Integer.toString(ProdutoCarrinho.getQuantidade());
        holder.tvQuantidade.setText(quantidade);

        holder.itemView.setOnClickListener(v -> {
            Intent i = new Intent(v.getContext(), ProdutosActivity.class);
            i.putExtra("prodNome", Produto.getNome());
            i.putExtra("prodImg",Produto.getImagemId());
            v.getContext().startActivity(i);
        });

        holder.btnMais.setOnClickListener(v -> {
            ProdutoCarrinho.setQuantidade(ProdutoCarrinho.getQuantidade() + 1);
            notifyItemChanged(position);
        });

        holder.btnMenos.setOnClickListener(v -> {
            if ( ProdutoCarrinho.getQuantidade() > 1) {
                ProdutoCarrinho.setQuantidade( ProdutoCarrinho.getQuantidade() - 1);
                notifyItemChanged(position);
            }
        });

    }

    @Override
    public int getItemCount() {
        return  this.carrinho.getProdutosCarrinho().size();
    }

    // ViewHolder
    public static class ProdutoViewHolder extends RecyclerView.ViewHolder {
        ImageView ivImage;
        TextView tvName;
        TextView tvPrice;
        TextView tvQuantidade;
        Button btnMais;
        Button btnMenos;

        public ProdutoViewHolder(@NonNull View itemView) {
            super(itemView);
            ivImage  = itemView.findViewById(R.id.ivProdutoImage);
            tvName   = itemView.findViewById(R.id.tvProdutoName);
            tvPrice  = itemView.findViewById(R.id.tvProdutoPrice);
            tvQuantidade  = itemView.findViewById(R.id.tvQuantidade);
            btnMais     = itemView.findViewById(R.id.btnMais);
            btnMenos    = itemView.findViewById(R.id.btnMenos);
        }

    }


}