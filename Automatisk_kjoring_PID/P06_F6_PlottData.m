%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
% P04_F6_PlottData.m
% 
% Denne plasseres enten i while-l�kka eller rett etterp�
%
% Husk syntaksen: plot(Tid(1:k),data(1:k))  
% Dette for � f� samme opplevelse n�r online=0 siden
% hele datasettet (1:end) eksisterer i den lagrede .mat fila
%
%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

figure(fig1)

hold on;
plot(Tid(1:k),Lys(1:k), 'b'); 
plot(Tid(1:k),ones(k,1) .* Referanse, 'r');
title('Avvik e(k) og referanse');
xlabel('Tid [sek]');
hold off;


%---------------------------------------------------
% tegn n� (viktig kommando)
%---------------------------------------------------
drawnow

