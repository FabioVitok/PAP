 
public class Acessorio extends Produto
{
    private static final String TIPO = "Acessorio";
    public Acessorio(int id, String nome, String cor, String tamanho, int imagemId, int stock, double peso, double precoVenda, double precoCusto)
    {
        super(id, nome, TIPO, cor, tamanho, imagemId, stock, peso, precoVenda, precoCusto);
    }
}
