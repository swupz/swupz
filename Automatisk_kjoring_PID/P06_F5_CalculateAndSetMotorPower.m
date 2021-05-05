%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
% P04_F5_CalculateAndSetMotorPower.m
% 
% Beregner hvordan motorene skal bevege seg
%
%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%



%------------------------------------------------
% Definer parametre til å beregne motorpådrag. 
%------------------------------------------------
% Basispådrag
u0 = 20; 
e(k) = Referanse - Lys(k);
Ts(k-1) = Tid(k) - Tid(k-1);
alfa = 0.1;

% PID-parameter
K_p = 2;
K_i = 2.5;
K_d = 2;

% Filtrert e(k)
e_f(k) = IIR_filter(e_f(k-1),e(k),alfa);

%------------------------------------------------
% Beregner motorpådrag og lagrer i datavektor
% (slett de motorene du ikke bruker og lag egen kode)
%------------------------------------------------
P(k) = K_p * e(k);
I(k) = EulerForward(I(k-1),K_i*e(k-1), Ts(k-1));
D(k) = Derivation(e_f(k-1:k),Ts(k-1));

% Hindrer utkjøring av bane
if I(k) > 30
     I(k) = 30;
 elseif I(k) < -30
     I(k) = -30;
 end

% Motor med PDI-reg.
PowerA(k) = u0 - (P(k) + I(k));% + D(k));
PowerB(k) = u0 + (P(k) + I(k));% + D(k));
    
if online
    
    %------------------------------------------------
    % Setter powerdata mot EV3
    % Går ikke fortere enn -100 -> +100 selv 
    % om powerverdi er større
    % (slett de motorene du ikke bruker)
    %------------------------------------------------
    motorA.Speed = PowerA(k);
    motorB.Speed = PowerB(k);
    %motorC.Speed = PowerC(k);
    
    start(motorA)
    start(motorB)
    %start(motorC)

else
    %------------------------------------------------
    % simulerer EV3-Matlab kommunikasjon i online=0
    %------------------------------------------------
    pause(0.01) 
end
