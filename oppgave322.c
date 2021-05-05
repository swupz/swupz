#include <stdlib.h>
#include <stdio.h>
#include <sys/types.h>
#include <unistd.h>
#include <sys/wait.h>
#include <fcntl.h>
#include <sys/mman.h>
#include <errno.h>
#include <sys/stat.h>
#include <string.h>

int main()
{
	int fd = shm_open("/memoryObject", O_CREAT | O_EXCL | O_RDWR, 0666);
	if (fd < 0) {
		perror("shm_open() failed");
		return EXIT_FAILURE;
	}

	ftruncate(fd, 4096);
	void *data = mmap(0, 4096, PROT_READ | PROT_WRITE, MAP_SHARED, fd, 0);
	printf("Sender mapped adress: %p\n", data);

	char str[100];			// Blir brukt til å mellomlagre i som string. Brukes lengre nede.
	int i;
	printf( "Enter a value: ");	// Spør etter et heltall.
	scanf("%d", &i);		// Lar deg skrive inn et heltall i terminalen.

	if (i < 1) {
		printf("The entered value must be above 1");	// Tallet skal være større enn 0.
		exit(0);
	}

	pid_t child_pid = fork();	// Starter child-prosess.

	if (child_pid > 0) {
		wait(0);		// Venter på at child-prosessen blir ferdig, før den fortsetter.

		printf("%s\n", (char *)data);	// Printer ut alt som er lagret i det delte-minnet.

		munmap(data, 4096);
		close(fd);			// Lukker alt som har med det delte minnet å gjøre.
		shm_unlink("/memoryObject");

		exit(0);
	}
	else {
		sprintf(str, "%d", i);
		sprintf(data,"%s", str);		// Legger det første tallet i delt-minne.
		data += strlen(str);
		while (i != 1) {			// Løkken fortsetter til tallet blir 1.
			if (i % 2 == 1) {		// Gjør noe hvis tallet er et oddetall.
				i = i * 3 + 1;
			}
			else {				// Gjør noe hvis tallet er et partall.
				i = i / 2;
			}

			sprintf(str, "%d", i);
			sprintf(data, " %s ", str);	// Legger de neste tallene i delt-minne.
			data += strlen(str) + 1;
		}
	}

	return 0;
}
