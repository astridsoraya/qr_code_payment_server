
import java.awt.image.BufferedImage;
import java.io.File;
import java.io.IOException;
import java.util.logging.Level;
import java.util.logging.Logger;
import javax.imageio.ImageIO;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @author ASUS A455LA
 */
public class Main {

    /**
     * @param args the command line arguments
     */
    public static void main(String[] args) {
        try {
            // TODO code application logic here
            File secretImageFile = new File(args[0]);
            BufferedImage secretImageBuffered = ImageIO.read(secretImageFile);
            BinaryImage secretImage = new BinaryImage(secretImageBuffered);
            
            File authImageFile = new File(args[1]);
            BufferedImage authImageBuffered = ImageIO.read(authImageFile);
            BinaryImage authImage = new BinaryImage(authImageBuffered);
            
            secretImage.resizeImage(authImage.getMatrix().length, secretImage.getMatrix()[0].length);
            authImage.resizeImage(secretImage.getMatrix()[0].length / 2, secretImage.getMatrix().length);
            
            BinaryVCAuthentication authentication = new BinaryVCAuthentication(3, secretImage, authImage);
            authentication.createShares();
            
            BinaryImage[] shares = authentication.getShadows();
            for (int i = 0; i < shares.length; i++) {
                String fileNames = "untitled_"+(i+1)+"_"+shares.length;
                File newFileName = new File(String.format("%s.%s", fileNames, "jpg"));
                ImageIO.write(shares[i].matrixToImage(shares[i].getMatrix()), "jpg", newFileName);
            }
            
            BinaryImage reconstructedSecret = authentication.reconstructSecretImage();
            String fileNames = "reconstructed_secret";
            File newFileName = new File(String.format("%s.%s", fileNames, "jpg"));
            ImageIO.write(reconstructedSecret.matrixToImage(reconstructedSecret.getMatrix()), "jpg", newFileName);
            
            BinaryImage reconstructedAuth = authentication.reconstructAuthenticationImage();
            fileNames = "reconstructed_auth";
            newFileName = new File(String.format("%s.%s", fileNames, "jpg"));
            ImageIO.write(reconstructedAuth.matrixToImage(reconstructedAuth.getMatrix()), "jpg", newFileName);
            
        } catch (IOException ex) {
            Logger.getLogger(Main.class.getName()).log(Level.SEVERE, null, ex);
        }
    }
    
}
