package com.example.imoral.models;
import java.io.Serializable;
import java.util.ArrayList;

public class ProdutoPai implements Serializable {

    private int id;
    private String nome;
    private String tipo;
    private String cor;
    private double preco_venda;
    private String image;
    ArrayList<ProdutoCarrinho> produtosFilho = new ArrayList<>();

    public ProdutoPai(int id, String nome, String tipo, String cor, double preco_venda, String image) {
        this.id = id;
        this.nome = nome;
        this.tipo = tipo;
        this.cor = cor;
        this.preco_venda = preco_venda;
        this.image = image;
        this.produtosFilho = new ArrayList<>();
    }

    public int getId() { return id;}

    public String getNome() {
        return nome;
    }
    public String getTipo() {
        return tipo;
    }
    public String getCor() {
        return cor;
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

