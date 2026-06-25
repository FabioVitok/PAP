package com.example.imoral.models;
import java.util.ArrayList;
public class Carrinho
{
    private int id;
    private Utilizador user;
    private double custoTotal;
    ArrayList<ProdutoCarrinho> produtosCarrinho = new ArrayList<>();

    public Carrinho()
    {
    }

    public Utilizador getUser()
    {
        return this.user;
    }

    public ArrayList<ProdutoCarrinho> getProdutosCarrinho() {
        return this.produtosCarrinho;
    }

    public int getId() {
        return id;
    }
}
