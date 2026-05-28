package com.example.imoral.models.Login;

import com.example.imoral.models.Utilizador;

public class LoginData {
    private Utilizador user;
    private String jwt;

    public Utilizador getUser() {
        return user;
    }

    public String getJwt() {
        return jwt;
    }
}