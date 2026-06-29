package com.example.imoral.models;

import java.io.Serializable;

public class Pedido implements Serializable
{
    private int pedido_id;
    private String dt_compra;
    private String metodo_pagamento;
    private String valor;
    private String morada_entrega;
    private String metodo_envio;
    private String entregadora;
    private String peso;
    
    public Pedido() {}

    public int getPedido_id() { return pedido_id; }

    public String getDt_compra() { return dt_compra; }

    public String getMetodo_pagamento() { return metodo_pagamento; }

    public String getValor() { return valor; }

    public String getMorada_entrega() { return morada_entrega; }

    public String getMetodo_envio() { return metodo_envio; }

    public String getEntregadora() { return entregadora; }

    public String getPeso() { return peso; }
    

        
}
