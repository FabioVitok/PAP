package com.example.imoral;

import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.CheckBox;
import android.widget.CompoundButton;
import android.widget.EditText;
import android.widget.ImageButton;
import android.widget.TextView;
import android.widget.Toast;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;

import com.example.imoral.models.Produto;
import com.example.imoral.models.ProdutoPai;
import com.google.android.material.bottomsheet.BottomSheetDialogFragment;

import java.util.ArrayList;
import java.util.List;
import java.util.stream.Stream;

public class EntregaBottomSheet extends BottomSheetDialogFragment {

    public interface OnEntregaConfirmadaListener {
        void onEntregaConfirmada(String nomeContato, String numTelefoneCompleto, String morada, String endereco, Boolean salvar);
    }

    public void setOnEntregaConfirmadaListener(OnEntregaConfirmadaListener listener) {
        this.listener = listener;
    }

    private OnEntregaConfirmadaListener listener;
    private ImageButton btnFechar;
    private EditText etNomeContato, etDDI, etNumTelefone, etMorada, etMoradaEspecific, etCodigoPostal, etDistrito, etConcelho;
    private String nomeContato, numTelefoneCompleto, morada, endereco;
    private CheckBox cbGuardar;
    private Button btnSalvar;
    private Boolean salvar;
    public static EntregaBottomSheet newInstance() {

        // Cria uma nova instância do BottomSheet
        EntregaBottomSheet fragment = new EntregaBottomSheet();

        // Retorna o bottomSheet com o produto
        return fragment;
    }

    @Nullable
    @Override
    public View onCreateView(@NonNull LayoutInflater inflater,
                             @Nullable ViewGroup container,
                             @Nullable Bundle savedInstanceState) {
        // Associa a classe ao respetivo layout
        View view = inflater.inflate(R.layout.bottom_sheet_entrega, container, false);
        initializeViews(view);
        listeners();
        return view;
    }

    private void initializeViews(View view){
        btnFechar = view.findViewById(R.id.btnFechar);
        etNomeContato = view.findViewById(R.id.etNomeContato);
        etDDI = view.findViewById(R.id.etDDI);
        etNumTelefone = view.findViewById(R.id.etNumTelefone);
        etMorada = view.findViewById(R.id.etMorada);
        etMoradaEspecific = view.findViewById(R.id.etMoradaEspecific);
        etCodigoPostal = view.findViewById(R.id.etCodigoPostal);
        etDistrito = view.findViewById(R.id.etDistrito);
        etConcelho = view.findViewById(R.id.etConcelho);
        cbGuardar = view.findViewById(R.id.cbGuardar);
        btnSalvar = view.findViewById(R.id.btnSalvar);
    }

    private void checkBoxlisteners() {
        cbGuardar.setOnCheckedChangeListener((button, isChecked) -> {
            salvar = isChecked;
        });
    }

    private void salvarDados(){
        nomeContato = etNomeContato.getText().toString();
        numTelefoneCompleto = (etDDI.getText().toString() + " " + etNumTelefone.getText().toString());
        morada = (etMorada.getText().toString() + ", " + etMoradaEspecific.getText().toString());
        endereco = (etConcelho.getText().toString() + ", " + etDistrito.getText().toString() + ", Portugal, " + etCodigoPostal.getText().toString());

    }

    private void listeners(){
        btnFechar.setOnClickListener(v -> {
            dismiss(); // Fecha o BottomSheet
        });

        btnSalvar.setOnClickListener(v -> {
            checkBoxlisteners();
            if(Stream.of(etNomeContato, etNumTelefone, etDDI).anyMatch(et -> et.getText().toString().trim().isEmpty())){
                Toast.makeText(getContext(), "Preencha todos os campos", Toast.LENGTH_SHORT).show();
            } else {
                salvarDados();
                if (listener != null) {
                    listener.onEntregaConfirmada(
                            nomeContato,
                            numTelefoneCompleto,
                            morada,
                            endereco,
                            salvar
                    );
                }
                dismiss();
            }

        });
    }


}
