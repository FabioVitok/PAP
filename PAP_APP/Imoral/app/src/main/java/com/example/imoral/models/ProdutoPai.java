package com.example.imoral.models;

import java.util.ArrayList;

public class ProdutoPai {
    private String nome;
    private double preco_venda;
    private String image;
    ArrayList<ProdutoCarrinho> produtosFilho = new ArrayList<>();

    public ProdutoPai(String nome, double preco_venda, String image) {
        this.nome = nome;
        this.preco_venda = preco_venda;
        this.image = image;
        this.produtosFilho = new ArrayList<>();
    }

    public String getNome() {
        return nome;
    }
    public double getPreco_venda() {
        return preco_venda;
    }
    public String getImage() {
        return image;
    }

    public ArrayList<ProdutoCarrinho> getProdutosFilho() {
        return produtosFilho;
    }

}

