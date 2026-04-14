package com.example.imoral.models;
public class Acessorio extends Produto
{
    private static final String TIPO = "Acessorio";
    public Acessorio(int id, String nome, String cor, String tamanho, String imagem, int stock, double peso, double precoVenda, double precoCusto)
    {
        super(id, nome, TIPO, cor, tamanho, imagem, stock, peso, precoVenda, precoCusto);
    }
}
