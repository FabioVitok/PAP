package com.example.imoral.models;
public class ProdutoCarrinho
{
    int id;
    int id_carrinho;
    int id_produto;
    int quantidade;
    String nome;
    String image;
    String tamanho;
    double preco_venda;
    
    public ProdutoCarrinho() {}


    public int getId() {
        return id;
    }

    public int getIdCarrinho() {
        return id_carrinho;
    }

    public int getIdProduto() {
        return id_produto;
    }

    public int getQuantidade()
    {
        return this.quantidade;
    }
    
    public void setQuantidade(int quantidade)
    {
        this.quantidade = quantidade;
    }

    public String getNome() {
        return nome;
    }

    public String getImage() {
        return image;
    }

    public String getTamanho() {
        return tamanho;
    }

    public double getPrecoVenda() {
        return preco_venda;
    }
}
