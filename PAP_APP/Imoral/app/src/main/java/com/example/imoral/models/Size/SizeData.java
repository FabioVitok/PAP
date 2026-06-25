package com.example.imoral.models.Size;

import com.example.imoral.models.Produto;

import java.util.List;
import com.google.gson.annotations.SerializedName;

public class SizeData {

    @SerializedName("products")
    private List<Produto> produtos;

    public List<Produto> getProdutos() {
        return produtos;
    }
}