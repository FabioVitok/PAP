package com.example.imoral.models.Carrinhos;

public class CarrinhoResponse {
    private boolean success;
    private String message;
    private CarrinhoData data;

    public boolean isSuccess() {
        return success;
    }

    public String getMessage() {
        return message;
    }

    public CarrinhoData getData() {
        return data;
    }
}

