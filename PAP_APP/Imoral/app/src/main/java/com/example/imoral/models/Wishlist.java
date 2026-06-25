package com.example.imoral.models;
import java.util.HashMap;
public class Wishlist
{
    private int id;
    private Utilizador user;
    HashMap<String, Produto> produtos;
    public Wishlist(){
    }

    public int getId() {
        return id;
    }

    public Utilizador getUser()
    {
        return this.user;
    }
    
    
    public HashMap getProdutos()
    {
        return this.produtos;
    } 
    
   
}
