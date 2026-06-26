package com.example.imoral.models.Login;

import com.example.imoral.models.Carrinho;
import com.example.imoral.models.Utilizador;
import com.example.imoral.models.Wishlist;

public class LoginData {
    private Utilizador user;
    private Carrinho carrinho;
    private Wishlist wishlist;
    private String jwt;

    public Utilizador getUser() {
        return user;
    }

    public Carrinho getCarrinho() {
        return carrinho;
    }

    public Wishlist getWishlist() {
        return wishlist;
    }

    public String getJwt() {
        return jwt;
    }
}