package com.example.imoral.models;

import android.annotation.SuppressLint;
import android.content.Context;

// Metodo para encontrar uma imagem pelo nome
public class ImageHelper {

    // Procura uma imagem pelo nome e devolve o seu número ID
    @SuppressLint("DiscouragedApi")
    public static int getDrawableResourceId(Context context, String resourceName) {
        // Pede ao Android para encontrar a imagem pelo nome
        return context.getResources().getIdentifier(
                resourceName,       // Nome da imagem a procurar
                "drawable",         // Procura na pasta drawable
                context.getPackageName() // Dentro desta aplicação
        );
    }

}
