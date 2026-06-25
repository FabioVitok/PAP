package com.example.imoral.models.Carrinhos;

import com.example.imoral.models.ProdutoCarrinho;

import java.util.List;
import com.google.gson.annotations.SerializedName;

public class CarrinhoData {

    @SerializedName("carrinho_produtos")
    private List<ProdutoCarrinho> produtos;

    public List<ProdutoCarrinho> getProdutos() {
        return produtos;
    }
}
