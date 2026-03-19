package com.example.imoral.models;
public class Roupa extends Produto
{
    private static final String TIPO = "Roupa";
    public Roupa(int id, String nome, String cor, String tamanho, int stock, double peso, double precoVenda, double precoCusto)
    {
        super(id, nome, TIPO, cor, tamanho, stock, peso, precoVenda, precoCusto);
    }
}
