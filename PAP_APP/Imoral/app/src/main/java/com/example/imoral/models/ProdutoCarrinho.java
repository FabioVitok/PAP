package com.example.imoral.models;
public class ProdutoCarrinho
{
    private Produto produto;
    private int quantidade;
    private boolean selecionado;
    
    public ProdutoCarrinho(Produto produto, int quantidade)
    {
        this.produto = produto;
        this.quantidade = quantidade;
    }
    
    public Produto getProduto()
    {
        return this.produto;
    }
    
    public int getQuantidade()
    {
        return this.quantidade;
    }
    
    public void setQuantidade(int quantidade)
    {
        this.quantidade = quantidade;
    }
    
    public boolean getSelecionado()
    {
        return this.selecionado;
    }
    
    public void setSelecionado(boolean selecionado)
    {
        this.selecionado = selecionado;
    }
}
