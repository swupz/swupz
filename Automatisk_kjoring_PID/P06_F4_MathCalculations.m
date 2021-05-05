%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
% P04_F4_MathCalculations.m
% 
% Her programmerer du beregninger som skal gjøres
%
%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

%------------------------------------------------
% Definer parametre som brukes i beregningene. 
%------------------------------------------------
Ts(k-1) = Tid(k) - Tid(k-1);
e(k) = Referanse - Lys(k);


my(k) = mean(Lys(1:k));
sigma(k) = std(Lys(1:k));
sigma2(k) = var(Lys(1:k));

IAE(k) = EulerForward(IAE(k-1), abs(e(k)), Ts(k-1));
ITAE(k) = EulerForward(ITAE(k-1), Tid(k)*abs(e(k)), Ts(k-1));
MAE(k) = IAE(k)/k;
TV_A(k) = EulerForward(TV_A(k-1), abs(PowerA(k)-PowerA(k-1)), Ts(k-1));
TV_B(k) = EulerForward(TV_B(k-1), abs(PowerB(k)-PowerB(k-1)), Ts(k-1));

if Lys(k) > 50
    JoyMainSwitch = 1;
    stop(motorA);           % Stopp motorer
    stop(motorB);
end
