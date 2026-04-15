package com.example.imoral.models;
import java.util.HashMap;
public class Carrinho
{
    private int id;
    private Utilizador user;
    private double custoTotal;
    HashMap<String, ProdutoCarrinho> produtos;
     
    public Carrinho(int id, Utilizador user)
    {
        this.id = id;
        this.user = user;
        this.produtos = new HashMap<>();
    }
 
    public Utilizador getUser()
    {
        return this.user;
    }
    
    // Metodo para calcular o peso do carrinho ignorando se o produto está selecionado ou não
    public double pesoTotal()
    {
        double pesoTotal = 0;
        for(String key : this.produtos.keySet()){
            double pesoProduto = this.produtos.get(key).getProduto().getPeso();
            int quantidadeProduto = this.produtos.get(key).getQuantidade();
            pesoTotal = pesoTotal + (pesoProduto * quantidadeProduto);
        }
        
        return pesoTotal;
    }
}
