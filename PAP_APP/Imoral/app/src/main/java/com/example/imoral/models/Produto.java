package com.example.imoral.models;

import java.io.Serializable;

public class Produto implements Serializable
{
    private int id;
    private int idProdutoPai;
    private String tamanho;
    private double peso;
    private double precoCusto;
    private int stock;

    public Produto(int id, String tamanho, double peso, double precoCusto, int stock)
    {
        this.id = id;
        this.tamanho = tamanho;
        this.peso = peso;
        this.precoCusto = precoCusto;
        this.stock = stock;;
    }

    public int getId() {return id;}
    public String getTamanho()
    {
        return this.tamanho;
    }
    public int getStock()
    {
        return this.stock;
    }
    
    public void setStock(int stock)
    {
        this.stock = stock;
    }
    
    public double getPeso()
    {
        return this.peso;
    }

    public double getPrecoCusto()
    {
        return this.precoCusto;
    }

}
