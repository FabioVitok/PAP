public class Acessorio extends Produto
{
    private static final String TIPO = "Acessorio";
    public Acessorio(int id, String nome, String cor, String tamanho, int stock, double peso, double precoVenda, double precoCusto)
    {
        super(id, nome, TIPO, cor, tamanho, stock, peso, precoVenda, precoCusto);
    }
}
