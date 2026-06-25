package com.example.imoral;

import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.ImageButton;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import com.example.imoral.adapters.TamanhoAdapter;
import com.example.imoral.models.Produto;
import com.example.imoral.models.ProdutoPai;
import com.google.android.material.bottomsheet.BottomSheetDialogFragment;

import java.util.ArrayList;
import java.util.List;


public class CompraBottomSheet extends BottomSheetDialogFragment {

    public interface OnCompraListener {

        // metodo chamado quando o utilizador confirma uma compra.
        void onCompraRealizada(int quantidade, int produtoIdSelecionado);
    }

    private OnCompraListener compraListener;

    private TamanhoAdapter TamanhoAdapter;

    private int quantidade = 1;

    private RecyclerView rvTamanhos;

    private List<Produto> produtos = new ArrayList<>();

    int previousPosition;

    public void setOnCompraListener(OnCompraListener listener) {
        this.compraListener = listener;
    }

    public static CompraBottomSheet newInstance(ProdutoPai produtoPai, List<Produto> tamanhos, int position) {

        // Cria uma nova instância do BottomSheet
        CompraBottomSheet fragment = new CompraBottomSheet();

        // Cria um Bundle
        Bundle bundle = new Bundle();

        // Coloca os dados no Bundle
        bundle.putSerializable("ProdutoPai", produtoPai);
        bundle.putSerializable("tamanhos", new ArrayList<>(tamanhos));
        bundle.putInt("position", position);

        // Anexa o Bundle ao Fragment
        fragment.setArguments(bundle);

        // Retorna o bottomSheet com o produto
        return fragment;
    }

    @Nullable
    @Override
    public View onCreateView(@NonNull LayoutInflater inflater,
                             @Nullable ViewGroup container,
                             @Nullable Bundle savedInstanceState) {
        // Associa a classe ao respetivo layout
        View view = inflater.inflate(R.layout.bottom_sheet_compra, container, false);



        // Verifica se dados foram passados dados no bundle
        if (getArguments() != null) {

            //Atribui os dados do budnle a variaveis locais
            produtos = (List<Produto>) getArguments().getSerializable("tamanhos");
            previousPosition = getArguments().getInt("position");

        }
        // Associar as variaveis locais aos respetivos elementos do xml
        TextView tvQuantidade = view.findViewById(R.id.tvQuantidade);
        Button btnMenos = view.findViewById(R.id.btnMenos);
        Button btnMais = view.findViewById(R.id.btnMais);
        Button btnComprar = view.findViewById(R.id.btnComprar);
        ImageButton btnFechar = view.findViewById(R.id.btnFechar);
        rvTamanhos = view.findViewById(R.id.rvTamanhos);


        setupTamanhosList();
        TamanhoAdapter.submitList(produtos);
        TamanhoAdapter.setSelectedPosition(previousPosition);

        // setOnClickListener do botão menos
        btnMenos.setOnClickListener(v -> {
            // Verifica se a quantidade é maior que 1 (quantidade não pode ser 0 ou negativo)
            if (quantidade > 1) {
                // Diminui a quantidade
                quantidade--;
                // Atualiza a o textview da quantidade
                tvQuantidade.setText(String.valueOf(quantidade));
            }
        });

        // setOnClickListener do botão mais
        btnMais.setOnClickListener(v -> {
            // Verifica se a quantidade é menor que o stock disponivel (quantidade não pode ser maior que o stock)
            if(quantidade < 20) {
                // Aumenta a quantidade
                quantidade++;
                // Atualiza a o textview da quantidade
                tvQuantidade.setText(String.valueOf(quantidade));

            }
        });

        // setOnclickListener para o botão comprar
        btnComprar.setOnClickListener(v -> {
            // Notifica o listener sobre a compra realizada
            if (compraListener != null) {
                int posSelecionada = TamanhoAdapter.getSelectedPosition();
                int idProdutoSelecionado = produtos.get(posSelecionada).getId();
                compraListener.onCompraRealizada(quantidade, idProdutoSelecionado);
            }
            dismiss(); // Fecha o BottomSheet
        });


        // setOnclickListener para o botão cancelar
        btnFechar.setOnClickListener(v -> {
            dismiss(); // Fecha o BottomSheet
        });

        return view;
    }

    private void setupTamanhosList() {
        TamanhoAdapter = new TamanhoAdapter(R.layout.item_tamanho_bottomsheet);

        LinearLayoutManager layoutManager
                = new LinearLayoutManager(getContext(), LinearLayoutManager.HORIZONTAL, false);
        rvTamanhos.setLayoutManager(layoutManager);
        rvTamanhos.setAdapter(TamanhoAdapter);
    }

}
