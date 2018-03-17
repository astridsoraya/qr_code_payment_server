/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

import java.util.Random;

/**
 *
 * @author Astrid
 */
public class BinaryVCAuthentication{
    private int n;
    private BinaryImage secretImage;
    private BinaryImage authenticationImage;
    private BinaryImage[] shares;
    
    public BinaryVCAuthentication(int n, BinaryImage secretImage, BinaryImage authenticationImage) {
        this.n = n;
        this.secretImage = secretImage;
        this.authenticationImage = authenticationImage;
        
        if(!this.checkAuthImageSize()) {
            int secretHeight = this.secretImage.getMatrix().length;
            int secretWidth = this.secretImage.getMatrix()[0].length;
            
            this.authenticationImage.resizeImage(secretHeight, secretWidth  / 2);
        }
        
        
        this.shares = new BinaryImage[n];

        for (int i = 0; i < shares.length; i++) {
            shares[i] = new BinaryImage(this.secretImage.getMatrix().length, this.secretImage.getMatrix()[0].length);
        }
        
    }
    
    public BinaryVCAuthentication(BinaryImage[] shares) {
        this.shares = shares;
    }
    
    public BinaryImage getSecretImage() {
        return secretImage;
    }

    public BinaryImage getAuthenticationImage() {
        return authenticationImage;
    }
    
    public BinaryImage[] getShadows() {
        return shares;
    }
    
    public void setShadows(BinaryImage[] shadows) {
        this.shares = shares;
    }
    
    public BinaryImage reconstructSecretImage() {
        int height = shares[0].getMatrix().length;
        int width = shares[0].getMatrix()[0].length;
        
        int[][] reconstructionSecretMatrix = new int[height][width];
                     
        for (int i = 0; i < height; i++) {
                for (int j = 0; j < width; j++) {
                    
                    int temp = shares[0].getMatrix()[i][j];
                    for (int l = 1; l < shares.length; l++) {
                        temp = Utilities.xorOperation(temp, shares[l].getMatrix()[i][j]);
                    }
                    reconstructionSecretMatrix[i][j] = temp;    
                }
        }
        return new BinaryImage(reconstructionSecretMatrix);
    }

    public BinaryImage reconstructAuthenticationImage() {
        int height = shares[0].getMatrix().length;
        int width = shares[0].getMatrix()[0].length / 2;
        
        int[][] authenticationMatrix = new int[height][width];
        
        for (int i = 0; i < height; i++) {
                for (int j = 0; j < width; j++) {
                    
                    int temp = shares[0].getMatrix()[i][j + width];
                    for (int l = 1; l < shares.length; l++) {
                        temp = Utilities.xorOperation(temp, shares[l].getMatrix()[i][j]);
                    }
                    
                    authenticationMatrix[i][j] = temp;      
                }
        }
        return new BinaryImage(authenticationMatrix);
    }

    public void createShares() {
        int height = secretImage.getMatrix().length;
        int width = secretImage.getMatrix()[0].length;

        int[][][] tempShadows = new int[n][height][width];

        Random rd = new Random();
        
        for (int i = 0; i < n; i++) {
            for (int j = 0; j < height; j++) {
                for (int l = 0; l < width; l++) {
                    if (l >= width / 2 && i == 0) {
                    } else {
                        tempShadows[i][j][l] = rd.nextInt(2);
                    }

                }
            }
        }

        for (int i = 1; i < n; i++) {
            for (int j = 0; j < height; j++) {
                for (int l = 0; l < width / 2; l++) {

                    int temp = secretImage.getMatrix()[j][l];

                    for (int m = 0; m < n; m++) {
                        if (m != i) {
                            temp = Utilities.xorOperation(temp, tempShadows[m][j][l]);
                        }
                    }

                    tempShadows[i][j][l] = temp;

                }
            }
        }
        
        for (int i = 0; i < height; i++) {
            for (int j = 0; j < width / 2; j++) {

                int temp = authenticationImage.getMatrix()[i][j];

                for (int l = 1; l < shares.length; l++) {
                    temp = Utilities.xorOperation(temp, tempShadows[l][i][j]);
                }

                tempShadows[0][i][j + (width / 2)] = temp;
            }
        }
        
        for (int i = 1; i < n; i++) {
            for (int j = 0; j < height; j++) {
                for (int l = width / 2; l < width; l++) {

                    int temp = secretImage.getMatrix()[j][l];
                    for (int m = 0; m < n; m++) {
                        if (m != i) {
                            temp = Utilities.xorOperation(temp, tempShadows[m][j][l]);
                        }
                    }

                    tempShadows[i][j][l] = temp;
                }
            }

        }

        for (int i = 0; i < n; i++) {
            int[][] convertedShadows = new int[height][width];
            convertedShadows = tempShadows[i];
            
            shares[i].setMatrix(convertedShadows);
        }
    }

    public boolean checkAuthImageSize() {
        int secretHeight = secretImage.getMatrix().length;
        int secretWidth = secretImage.getMatrix()[0].length;
        
        int authHeight = authenticationImage.getMatrix().length;
        int authWidth = authenticationImage.getMatrix()[0].length;
        
        return (secretHeight == authHeight && secretWidth / 2 == authWidth);
    }

    public boolean[] checkCoverImagesSize(BinaryImage[] coverImages) {
        int secretHeight = secretImage.getMatrix().length;
        int secretWidth = secretImage.getMatrix()[0].length;
        boolean[] falseSize = new boolean[coverImages.length];
        
        for (int i = 0; i < falseSize.length; i++) {
            int coverHeight = coverImages[i].getMatrix().length;
            int coverWidth = coverImages[i].getMatrix()[0].length;
            
            if(secretHeight == coverHeight && secretWidth == coverWidth){
                falseSize[i] = true;
            }
        }
        
        return falseSize;
    }

    public boolean checkSharesSize(BinaryImage[] shares) {
        int coverHeight = shares[0].getMatrix().length;
        int coverWidth = shares[0].getMatrix()[0].length;
        boolean falseSize = true;
        
        for (int i = 1; i < shares.length && falseSize; i++) {
            int tempCoverHeight = shares[i].getMatrix()[0].length;
            int tempCoverWidth = shares[i].getMatrix()[0].length;
            
            if(coverHeight != tempCoverHeight && coverWidth != tempCoverWidth){
                falseSize = false;
            }
            else{
                coverHeight = tempCoverHeight;
                coverWidth = tempCoverWidth;
            }
        }
        
        return falseSize;
    }
    
}
