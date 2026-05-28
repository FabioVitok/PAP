package com.example.imoral.models.Home;

import com.example.imoral.models.ProdutoPai;

import java.util.List;
import com.google.gson.annotations.SerializedName;

public class HomeData {

    @SerializedName("products")
    private List<ProdutoPai> produtos;

    public List<ProdutoPai> getProdutos() {
        return produtos;
    }
}