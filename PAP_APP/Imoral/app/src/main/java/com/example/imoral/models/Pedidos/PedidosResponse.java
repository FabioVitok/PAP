package com.example.imoral.models.Pedidos;

public class PedidosResponse {
    private boolean success;
    private String message;
    private PedidosData data;

    public boolean isSuccess() {
        return success;
    }

    public String getMessage() {
        return message;
    }

    public PedidosData getData() {
        return data;
    }
}
