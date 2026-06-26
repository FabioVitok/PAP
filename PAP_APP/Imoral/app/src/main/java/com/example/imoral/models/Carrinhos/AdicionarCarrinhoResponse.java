package com.example.imoral.models.Carrinhos;

public class AdicionarCarrinhoResponse {
    private boolean success;
    private String message; // se a tua API devolver uma mensagem

    public boolean isSuccess() { return success; }
    public String getMessage() { return message; }
}