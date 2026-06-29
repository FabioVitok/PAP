package com.example.imoral.models.Pedidos;

public class CheckoutResponse {
    private boolean success;
    private String message; // se a tua API devolver uma mensagem

    public boolean isSuccess() { return success; }
    public String getMessage() { return message; }
}

