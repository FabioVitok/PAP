
public class Estado
{
    // tornar tudo final?
    private String nome; // Ex: Entregado
    private String descricao;
    private String cor;
    private boolean entregado;

    public Estado(String nome, String descricao, String cor, boolean entregado)
    {
        this.nome = nome;
        this.descricao = descricao;
        this.cor = cor;
        this.entregado = entregado;
    }
    
    public String getNome()
    {
        return this.nome;
    }
    
    public String getDescricao()
    {
        return this.descricao;
    }
  
    public String getCor()
    {
        return this.cor;
    }
    
    public boolean getEntregado()
    {
        return this.entregado;
    }
}
